<?php

namespace ModulesGarden\PlanetHoster\Core\Hook;

use ModulesGarden\PlanetHoster\Core\DependencyInjection;
use ModulesGarden\PlanetHoster\Core\Http\AbstractClientController;
use ModulesGarden\PlanetHoster\Core\Http\AbstractController;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Params;
use ModulesGarden\PlanetHoster\Core\UI\View;
use ModulesGarden\PlanetHoster\Core\UI\ViewAjax;
use function ModulesGarden\PlanetHoster\Core\Helper\isAdmin;
use function ModulesGarden\PlanetHoster\Core\make;

/**
 *  class HookIntegrator
 *  Prepares a views basing on /App/Integrations/Admin/ & /App/Integrations/Client controlers
 *  to be injected on WHMCS subpages
 */
class HookIntegrator
{

    /** @var null|string
     * HTML data to be returned as a result of the integration process
     */
    protected $integrationData = [];

    /** @var array
     *  avalible hook integrations list
     */
    protected $integrations = [];

    /**
     * @var bool
     *  determines if  works on admin or client area side
     */
    protected $isAdmin = false;

    public function __construct($hookParams)
    {
        $this->setHookParams($hookParams);

        $this->checkIsAdmin();

        $this->integrate();
    }

    public function setHookParams($hookParams)
    {
        if (is_array($hookParams))
        {
            Params::createFrom($hookParams);
            $this->hookParams = $hookParams;
        }

        return $this;
    }

    /**
     * determines if  works on admin or client area side
     */
    public function checkIsAdmin()
    {
        $this->isAdmin = isAdmin();
    }

    /**
     * starts whole integration process
     */
    protected function integrate()
    {
        $this->loadAvailablePackagesIntegrations();
        $this->loadAvailableModuleIntegrations();

        $this->loadIntegrationData();
    }

    /**
     * search integration in packages dirs /packages/'package'/Integrations
     */
    protected function loadAvailablePackagesIntegrations()
    {
        $packages = Config::get('packages', []);

        foreach (array_keys(array_filter($packages, fn($enabled) => (bool)$enabled)) as $package)
        {
            $this->loadAvailableIntegrations('packages', $package, 'Integrations');
        }
    }

    /**
     * search integration in Module main dir /app/Integrations/Admin(Client)
     */
    protected function loadAvailableModuleIntegrations()
    {
        $this->loadAvailableIntegrations('app', 'Integrations', ucfirst(ModuleConstants::getLevel()));
    }

    /**
     * loads available integration from selected dirs
     */
    protected function loadAvailableIntegrations(string ...$dirs)
    {
        $hooksPath = ModuleConstants::getFullPath(...$dirs);
        $hooksNamespace = ModuleConstants::getFullNamespace(...array_map(fn($element) => ucfirst($element), $dirs));

        if (!file_exists($hooksPath) || !is_readable($hooksPath))
        {
            return false;
        }

        $files = scandir($hooksPath, 1);
        if ($files)
        {
            foreach ($files as $key => $value)
            {
                if ($value === '.' || $value === '..' || !(stripos($value, '.php') > 0))
                {
                    unset($files[$key]);
                    continue;
                }

                $this->addIntegration($hooksNamespace . '\\' . str_replace('.php', '', $value));
            }
        }
    }

    /**
     * adds integration instance to the integrations list for current page
     * @param null|string $className
     * @return bool
     */
    protected function addIntegration(?string $integrationClass)
    {
        if (!class_exists($integrationClass) || !is_subclass_of($integrationClass, AbstractHookIntegrationController::class))
        {
            return false;
        }

        //creates an instance of integration class
        $integrationInstance = DependencyInjection::create($integrationClass);
        if (method_exists($integrationInstance, 'validate') && !$integrationInstance->validate($this->hookParams))
        {
            return false;
        }

        //check if integration should be added to current page
        if (!$this->validateIntegrationInstance($integrationInstance))
        {
            return false;
        }

        $this->integrations[] = $integrationInstance;
    }

    /**
     * check if the integration should be added to current page
     * @param null|AbstractHookIntegrationController $instance
     * @return bool
     */
    public function validateIntegrationInstance($instance = null)
    {
        if (!is_subclass_of($instance, AbstractHookIntegrationController::class))
        {
            return false;
        }

        if ($instance->getJqSelector() === null)
        {
            return false;
        }

        if (!method_exists($instance->getControllerCallback()[0], $instance->getControllerCallback()[1]))
        {
            return false;
        }

        return true;
    }

    public function loadIntegrationData()
    {
        foreach ($this->integrations as $integration)
        {
            if (!$this->isIntegrationApplicable($integration))
            {
                continue;
            }

            $callbackData = $integration->getControllerCallback();

            /** @var
             * $integrationResult \ModulesGarden\PlanetHoster\Core\UI\View
             */
            $integrationResult = call_user_func([make($callbackData[0]), $callbackData[1]]);
            if (!($integrationResult instanceof View) && !($integrationResult instanceof ViewAjax))
            {
                continue;
            }

            $view = new HookIntegratorView($integrationResult, $integration);

            $this->updateIntegrationData($integration, $view->getHTML());
        }
    }

    /**
     * check if integration params match page/request params
     * @param null|AbstractHookIntegrationController $integration
     * @return bool
     */
    public function isIntegrationApplicable($integration = null)
    {
        //check just in case, in order not to kill whole WHMCS
        if (!$integration)
        {
            return false;
        }

        //check if filename is correct for the integration
        if ($integration->getFileName() && $this->hookParams['filename'] !== $integration->getFileName())
        {
            return false;
        }

        //check if all provided request params are correct for the integration
        foreach ($integration->getRequestParams() as $rKey => $rParam)
        {
            if (is_array($rParam))
            {
                $found = false;
                foreach ($rParam as $irParam)
                {
                    if (\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get($rKey) === $irParam)
                    {
                        $found = true;
                        break;
                    }
                }
                if (!$found)
                {
                    return false;
                }
            }
            elseif (\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get($rKey) !== $rParam)
            {
                return false;
            }
        }

        //check if integration callback is correct
        $integrationCallback = $integration->getControllerCallback();
        if ((!is_subclass_of($integrationCallback[0], AbstractController::class)
             && !is_subclass_of($integrationCallback[0], AbstractClientController::class))
            || !method_exists($integrationCallback[0], $integrationCallback[1]))
        {
            return false;
        }

        return true;
    }

    protected function updateIntegrationData($integrationDetails, $htmlData)
    {
        if (!is_string($htmlData) || $htmlData === '' || !$integrationDetails || !is_object($integrationDetails))
        {
            return false;
        }

        $this->integrationData[] = [
            'htmlData'           => $htmlData,
            'integrationDetails' => $integrationDetails,
        ];
    }

    /**
     * returns integration output
     */
    public function getHtmlCode()
    {
        return $this->getWrapperHtml();
    }

    protected function getWrapperHtml()
    {
        if (!$this->integrationData)
        {
            return null;
        }

        $wrapper = new HookIntegrationsWrapper($this->integrationData);

        return $wrapper->getHtml();
    }
}
