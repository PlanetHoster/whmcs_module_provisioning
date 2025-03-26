<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

/**
 * @method static set(string $name, $value)
 * @method static get(string $name, $default = null)
 * @method static forget(string $name)
 * @method static exists(string $name)
 */
class Session extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Session\Session::class;
    }
}
