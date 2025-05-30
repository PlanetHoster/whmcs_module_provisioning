<?php

namespace ModulesGarden\PlanetHoster\Core\CommandLine;

use ModulesGarden\PlanetHoster\Core\CommandLine\LoadCommands\LoadCommandsControllers;
use ModulesGarden\PlanetHoster\Core\CommandLine\LoadCommands\LoadCoreCommandsController;
use ModulesGarden\PlanetHoster\Core\CommandLine\LoadCommands\LoadCommandsControllersInterface;
use ModulesGarden\PlanetHoster\Core\CommandLine\LoadCommands\LoadCommandsControllersPackageServices;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends \Symfony\Component\Console\Application
{
    protected $dir = '';

    /**
     * @override
     */
    public function run(?InputInterface $input = null, ?OutputInterface $output = null)
    {
        $this->addCommandsProvider(new LoadCommandsControllers);
        $this->addCommandsProvider(new LoadCoreCommandsController);
        $this->addCommandsProvider(new LoadCommandsControllersPackageServices);

        parent::run();
    }

    public function addCommandsProvider(LoadCommandsControllersInterface $provider)
    {
        $commands = $provider->getCommands($this->dir);

        foreach ($commands as $command)
        {
            $this->add(new $command);
        }
    }
}
