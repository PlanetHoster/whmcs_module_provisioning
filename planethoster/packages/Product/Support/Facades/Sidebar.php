<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Support\Facades;

use ModulesGarden\PlanetHoster\Core\Support\Facades\AbstractFacade;
use ModulesGarden\PlanetHoster\Packages\Product\Services\Sidebar as SidebarService;

/**
 * @method static getByName(string $item)
 * @method static array getAll()
 */
class Sidebar extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return SidebarService::class;
    }
}