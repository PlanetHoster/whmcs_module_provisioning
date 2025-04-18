<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController;

abstract class Action extends AddonController
{
    public function runExecuteProcess($params = null)
    {
        try
        {
            return parent::runExecuteProcess($params);
        }
        catch (\Exception $ex)
        {
            return $ex->getMessage();
        }
    }
}
