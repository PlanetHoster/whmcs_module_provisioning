<?php

namespace ModulesGarden\PlanetHoster\Core\Routing\Middleware;

use ModulesGarden\PlanetHoster\Core\Http\Request;

abstract class AbstractMiddleware
{
    public function __invoke(Request $request, \Closure $next)/*: \ModulesGarden\PlanetHoster\Core\Http\Response*/
    {
        return $next($request);
    }
}