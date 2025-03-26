<?php

namespace ModulesGarden\PlanetHoster\Core\CommandLine\LoadCommands;

use ModulesGarden\PlanetHoster\Core\DependencyInjection\PackageServices;
use function ModulesGarden\PlanetHoster\Core\make;

class LoadCommandsControllersPackageServices implements LoadCommandsControllersInterface
{
    public function getCommands(string $dir = null): array
    {
        $commands = make(PackageServices::class)->getCommands();

        return $commands;
    }
}
