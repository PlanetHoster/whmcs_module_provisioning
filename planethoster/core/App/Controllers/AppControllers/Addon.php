<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AppControllerInterface;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class Addon extends \ModulesGarden\PlanetHoster\Core\App\Controllers\AppController implements AppControllerInterface
{
    public function getControllerInstanceClass($callerName, $params)
    {
        $functionName = str_replace(ModuleConstants::getModuleName() . '_', '', $callerName);


        $coreAddon = '\ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon\\' . ucfirst($functionName);
        if (class_exists($coreAddon) && is_subclass_of($coreAddon, AddonController::class))
        {
            return $coreAddon;
        }

        $appAddon = '\ModulesGarden\PlanetHoster\App\Http\Actions\\' . ucfirst($functionName);
        if (class_exists($appAddon) && is_subclass_of($appAddon, AddonController::class))
        {
            return $appAddon;
        }

        return null;
    }
}
