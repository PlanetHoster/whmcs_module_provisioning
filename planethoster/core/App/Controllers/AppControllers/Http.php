<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http\AdminPageController;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http\ClientPageController;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AppControllerInterface;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class Http extends \ModulesGarden\PlanetHoster\Core\App\Controllers\AppController implements AppControllerInterface
{
    public function getControllerInstanceClass($callerName, $params)
    {
        $functionName = strtolower(str_replace(ModuleConstants::getModuleName() . '_', '', $callerName));
        switch ($functionName)
        {
            //HTTP controllers
            case 'output':
                return AdminPageController::class;
            case 'clientarea':
                return ClientPageController::class;
        }

        return null;
    }
}
