<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

/**
 *  @method static run(string $command, array $values = [], string $userName = ''))
 */
class WhmcsApi extends AbstractFacade
{

    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\WHMCS\API\API::class;
    }
}