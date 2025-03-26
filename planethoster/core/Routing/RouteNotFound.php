<?php

namespace ModulesGarden\PlanetHoster\Core\Routing;

class RouteNotFound extends Route
{
    public function __construct()
    {
        $this->name = '404';
    }
}