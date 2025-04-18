<?php


namespace ModulesGarden\PlanetHoster\Packages\ModuleSettings\Support\Facades;

use ModulesGarden\PlanetHoster\Core\Support\Facades\AbstractFacade;

/**
 * @method static get(string $setting, $default = null)
 * @method static delete(string $setting);
 * @method static set(string $setting, $value)
 * @method static save(array $settings = []);
 */
class ModuleSettings extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Packages\ModuleSettings\Services\ModuleSettings::class;
    }
}