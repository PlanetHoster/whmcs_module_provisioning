<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

class Store extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Store::class;
    }
}