<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers;

abstract class AppController
{
    public function runController($callerName, $params)
    {
        $controller = $this->getControllerInstanceClass($callerName, $params);

        return (new $controller)->runExecuteProcess($params);
    }
}
