<?php

namespace ModulesGarden\PlanetHoster\Core\Routing\Middleware\Processors;

use ModulesGarden\PlanetHoster\Core\Http\Request;
use ModulesGarden\PlanetHoster\Core\Routing\Route;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;

class Controller
{
    public function run(Route $route, Request $request, callable $caller)
    {
        $next = fn($request) => $caller();

        foreach (Config::get('middlewares', []) as $middleware)
        {
            $next = fn($request) => $middleware($request, $next);
        }

        return $next($request);
    }
}