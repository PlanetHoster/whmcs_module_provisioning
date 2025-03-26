<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Routing;

use ModulesGarden\PlanetHoster\Core\Routing\Route;

interface RouteProviderInterface
{
    public function find(\Symfony\Component\HttpFoundation\Request $request, string $level) : ?Route;
}