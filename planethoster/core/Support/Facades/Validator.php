<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;


/**
 * @method static validate(array $data, array $rules, array $customAttributes = [], array $customValues = []);
 */
class Validator extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Validator::class;
    }
}
