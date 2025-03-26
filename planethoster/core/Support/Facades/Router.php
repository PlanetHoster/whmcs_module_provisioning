<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;


/**
 * @method static getCurrentRoute : \ModulesGarden\PlanetHoster\Core\Routing\Route
 */
class Router extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Router::class;
    }
}
