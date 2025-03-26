<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;


/**
 * @see \ModulesGarden\PlanetHoster\Core\Services\Messages
 * @method static alert(string $message)
 * @method static toast(string $message)
 * @method static flash(string $message)
 */
class Messages extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Messages::class;
    }
}
