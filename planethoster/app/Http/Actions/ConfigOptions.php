<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Http\Admin\Home;
use ModulesGarden\PlanetHoster\Core\UI\ViewConfigOptions;
use ModulesGarden\PlanetHoster\Core\UI\ViewIntegrationAddon;
use ModulesGarden\PlanetHoster\Packages\Samples\Http\Admin\Samples;

class ConfigOptions extends \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\ConfigOptions
{
    public function execute($params = null)
    {
        return (new ViewConfigOptions())->addElement(new \ModulesGarden\PlanetHoster\App\UI\Actions\ConfigOptions());
    }
}
