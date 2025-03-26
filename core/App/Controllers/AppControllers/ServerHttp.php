<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\AppControllers;

use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AppControllerInterface;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class ServerHttp extends \ModulesGarden\PlanetHoster\Core\App\Controllers\AppController implements AppControllerInterface
{
    public function getControllerInstanceClass($callerName, $params)
    {
        $functionName = strtolower(str_replace(ModuleConstants::getModuleName() . '_', '', $callerName));

        switch ($functionName)
        {
            case 'clientarea':
                return $params['model'] instanceof \WHMCS\Service\Addon ?
                    \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\ClientPageProductAddonController::class :
                    \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\ClientPageController::class ;
            default:
                throw new \Exception($functionName . ' is not implemented in ' . __CLASS__);
        }

        return null;
    }
}
