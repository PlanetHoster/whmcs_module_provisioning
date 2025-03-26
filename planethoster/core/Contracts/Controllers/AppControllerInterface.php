<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Controllers;

interface AppControllerInterface
{
    public function getControllerInstanceClass($callerName, $params);
}
