<?php

namespace ModulesGarden\PlanetHoster\Packages\ModuleSettings\Listeners;

use ModulesGarden\PlanetHoster\Core\Database\FileLoader;
use ModulesGarden\PlanetHoster\Core\Events\Listener;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class ModuleActivated extends Listener
{
    public function handle($payload = [])
    {
        (new FileLoader())
            ->performQueryFromFile(ModuleConstants::getFullPath('packages', 'ModuleSettings', 'Database', 'Schema.sql'));
    }
}
