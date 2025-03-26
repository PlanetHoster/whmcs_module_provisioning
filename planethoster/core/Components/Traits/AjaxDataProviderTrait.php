<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

use Exception;
use ModulesGarden\PlanetHoster\Core\Components\Action;
use ModulesGarden\PlanetHoster\Core\Components\Response\Response;
use ModulesGarden\PlanetHoster\Core\Contracts\CrudProviderInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\ResponseInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\CrudProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;

/**
 *  string $provider = CrudProvider::class
 * @property string $providerAction = CrudProvider::ACTION_CREATE
 */
trait AjaxDataProviderTrait
{
    use AjaxTrait
    {
        returnAjaxData as private parentReturnAjaxData;
    }

    /**
     * @var string
     */
    protected string $provider = CrudProvider::class;

    protected string $providerAction = CrudProvider::ACTION_CREATE;

    protected ?CrudProviderInterface $providerInstance = null;

    protected function ajaxProviderActionSlotBuilder(): string
    {
        return $this->providerAction ?? CrudProvider::ACTION_UPDATE;
    }

    /**
     * This is default action which is called when there is no specific action.
     * If you want to create your custom action create method with name process(Action Name)Name for example processReadAction, processDeleteAction
     * @param string $providerAction
     * @return mixed
     * @throws Exception
     */
    protected function processDefaultAction(string $providerAction)
    {
        return $this->runProviderAction($providerAction);
    }

    protected function runProviderAction(string $providerAction)
    {
        if (!method_exists($this->provider(), $providerAction))
        {
            throw new \Exception('invalid_provider_action');
        }

        return $this->provider()->{$providerAction}();
    }

    /**
     * Returns provider object
     * @return mixed
     */
    protected function provider()
    {
        return $this->providerInstance ?: $this->providerInstance = new $this->provider;
    }

    /**
     * @return ResponseInterface
     */
    public function returnAjaxData(): ResponseInterface
    {
        $providerAction = strtolower(Request::get('providerAction', 'read'));
        $action         = 'process' . ucfirst($providerAction) . 'Action';
        $action         = method_exists($this, $action) ? $action : 'processDefaultAction';

        try
        {
            $response = $this->$action($providerAction);
            if ($response instanceof ResponseInterface)
            {
                return $response;
            }
        }
        catch (\Illuminate\Validation\ValidationException $ex)
        {
            return (new Response([
                'FormValidationErrors' => $ex->errors(),
            ]))
                ->setError($this->translate('formValidationError'));
        }
        catch (\Exception $ex)
        {
            return (new Response())
                ->setError($this->translate($ex->getMessage()));
        }

        return (new Response())
            ->setActions([Action::reloadParent()])
            ->setSuccess($this->translate($providerAction . '_success'));
    }

    /**
     * @return string
     */
    public function getProviderAction(): string
    {
        return $this->providerAction;
    }
}
