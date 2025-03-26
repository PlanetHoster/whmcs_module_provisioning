<?php

use ModulesGarden\PlanetHoster\App\Cron\TestCommand;

return [
    'commands' => function () {
        return [
            new \ModulesGarden\PlanetHoster\Packages\Scheduler\Models\Command(TestCommand::class, "*/5 * * * *", ['someParam' => 997])
        ];
    }
];
