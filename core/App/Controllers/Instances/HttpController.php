<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Exceptions\PageNotFound;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http\ErrorPage;
use ModulesGarden\PlanetHoster\Core\App\Controllers\ResponseResolver;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Router;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\DefaultControllerInterface;
use ModulesGarden\PlanetHoster\Core\DependencyInjection;
use ModulesGarden\PlanetHoster\Core\Exceptions\UserException;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Routing\Middleware\Processors\Controller;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\Traits\AppParams;
use ModulesGarden\PlanetHoster\Core\Traits\ErrorCodesLibrary;
use ModulesGarden\PlanetHoster\Core\Traits\IsAdmin;
use ModulesGarden\PlanetHoster\Core\Traits\Lang;
use ModulesGarden\PlanetHoster\Core\Traits\OutputBuffer;
use ModulesGarden\PlanetHoster\Core\Traits\Params;

abstract class HttpController implements DefaultControllerInterface
{
    use ErrorCodesLibrary;
    use IsAdmin;
    use Lang;
    use OutputBuffer;
    use Params;

    protected $controllerResult = null;
    protected $responseResolver = null;

    protected $templateDir = null;
    protected $templateName = 'main';

    protected string $level;

    public function __construct()
    {
        $this->isAdmin();

        $this->responseResolver = new ResponseResolver();
        $this->level            = ModuleConstants::getLevel();

    }

    /**
     * @param null $controllerResult
     */
    public function setControllerResult($controllerResult)
    {
        $this->controllerResult = $controllerResult;
    }


    public function runExecuteProcess($params = null)
    {
        return $this->execute($params);
    }

    //@todo refactor

    public function run($params = null)
    {
        try
        {
            \ModulesGarden\PlanetHoster\Core\Support\Facades\Params::createFrom($params);
            $route = \ModulesGarden\PlanetHoster\Core\Support\Facades\Router::find($this->level);
            if (!$route || !$this->hasProperContext($route->getController()))
            {
                throw new PageNotFound();
            }
            else
            {
                $this->controllerResult = (new Controller())->run($route, Request::getFacadeRoot(), function() use ($route) {
                    $action = $route->getAction();
                    return DependencyInjection::create($route->getController())->$action();
                });
            }

            $this->preResolveResponse();

            return $this->resolveResponse();
        }
        catch (PageNotFound $ex)
        {
            $this->controllerResult = new Http\PageNotFound();
            $this->preResolveResponse();

            return $this->resolveResponse();
        }
        catch (UserException $ex)
        {
            $this->controllerResult = new Http\CustomErrorPage($ex->getMessage());
            $this->preResolveResponse();

            return $this->resolveResponse();
        }
        catch (\Throwable $ex)
        {
            $this->controllerResult = (new ErrorPage())->execute(array_merge($params, ['exception' => $ex]));

            $this->preResolveResponse();

            return $this->resolveResponse();
        }
    }

    protected function preResolveResponse()
    {

    }

    protected function hasProperContext($controller): bool
    {
        return $this->level === ModuleConstants::LEVEL_ADMIN && is_subclass_of($controller, AdminAreaInterface::class)
               || $this->level === ModuleConstants::LEVEL_CLIENT && is_subclass_of($controller, ClientAreaInterface::class);
    }

    public function resolveResponse()
    {
        return $this->responseResolver->setResponse($this->controllerResult)
            ->setTemplateName($this->getTemplateName())
            ->setTemplateDir($this->getTemplateDir())
            ->setPageController($this)
            ->resolve();
    }

    public function getTemplateName()
    {
        return $this->templateName;
    }

    public function getTemplateDir()
    {
        $this->templateDir = ModuleConstants::getResourcesDir() . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'controllers';

        return $this->templateDir;
    }
}
