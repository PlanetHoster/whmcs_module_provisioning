<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon;

use ModulesGarden\PlanetHoster\Core\Configuration\Data;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AddonControllerInterface;

/**
 * Module configuration wrapper
 */
class Config extends \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController implements AddonControllerInterface
{
    public function execute($params = [])
    {
        return [
            'name'        => \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.systemName'),
            'description' => \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.description'),
            'version'     => \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.version'),
            'author'      => \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.author'),
            'fields'      => \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.fields', [])
        ];
    }
}
