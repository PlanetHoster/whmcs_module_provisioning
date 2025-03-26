<?php

use ModulesGarden\PlanetHoster\Core\Events\Events\ModuleActivated;
use function ModulesGarden\PlanetHoster\Core\listen;

return [
    'bootstrap' => function() {
        listen(ModuleActivated::class, \ModulesGarden\PlanetHoster\Packages\ModuleSettings\Listeners\ModuleActivated::class);
        listen(\ModulesGarden\PlanetHoster\Core\Events\Events\ConfigOptionsLoaded::class, \ModulesGarden\PlanetHoster\Packages\ModuleSettings\Listeners\ModuleActivated::class);

        \ModulesGarden\PlanetHoster\Core\DependencyInjection\Container::getInstance()->singleton(\ModulesGarden\PlanetHoster\Packages\ModuleSettings\Services\ModuleSettings::class);
    },
];
