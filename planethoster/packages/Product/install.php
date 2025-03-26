<?php

use ModulesGarden\PlanetHoster\Core\Hook\HookManager;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ProductDuplicate;
use function ModulesGarden\PlanetHoster\Core\listen;

return [
    'bootstrap' => function() {
        HookManager::create(__DIR__, true);
        ProductDuplicate::checkAndInitDuplicateProcess();

        listen(
            \ModulesGarden\PlanetHoster\Core\Events\Events\ConfigOptionsLoaded::class,
            \ModulesGarden\PlanetHoster\Packages\Product\Listeners\ConfigOptionsLoaded::class
        );
    },
];
