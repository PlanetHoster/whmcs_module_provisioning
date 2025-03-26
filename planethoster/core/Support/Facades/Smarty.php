<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;


class Smarty extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Smarty::class;
    }
}
