<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

class Dispatcher extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Events\Dispatcher::class;
    }
}
