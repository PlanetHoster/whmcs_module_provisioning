<?php

namespace ModulesGarden\PlanetHoster\Core\App;

use ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers\Addon;
use ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers\Api;
use ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers\Http;
use ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers\ServerHttp;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\ServiceLocator;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Params;

class Application
{
    public function run(string $type, string $callerName, $params = null)
    {
        try
        {
            Params::createFrom($params);

            $controller = $this->getControllerClass($type, $callerName);

            $controllerInstance = new $controller;

            $result = $controllerInstance->runController($callerName, $params);

            return $result;
        }
        catch (\Throwable $exc)
        {
            $params['mgErrorDetails'] = $exc;
            $params['exception']      = $exc;

            $result = ServiceLocator::create(Controllers\Instances\Http\ErrorPage::class)->execute($params);


            return $result;
        }
    }

    public function getControllerClass(string $type, string $callerName = null)
    {
        $functionName = strtolower(str_replace(ModuleConstants::getModuleName() . '_', '', $callerName));

        switch ($type . '.' . $functionName)
        {
            //HTTP controllers
            case 'server.output':
            case 'server.clientarea':
                return ServerHttp::class;
            case 'addon.output':
            case 'addon.clientarea':
                return Http::class;
            //API controller
            case 'server.api':
            case 'addon.api':
                return Api::class;
            //Addon controllers
            default:
                return Addon::class;
        }
    }
}
