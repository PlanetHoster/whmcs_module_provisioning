<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

/**
 * @method static set(string $name, $value)
 * @method static get(string $name, $default = null)
 * @method static delete(string $name)
 * @method static getMany(array $keys = [])
 * @method static createFrom(array $data = [])
 * @method static all()
 */
class Params extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Params::class;
    }
}
