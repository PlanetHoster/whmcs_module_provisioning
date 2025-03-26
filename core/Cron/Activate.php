<?php

namespace ModulesGarden\PlanetHoster\Core\Cron;

use ModulesGarden\PlanetHoster\Core\CommandLine\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon\Activate as ActivateController;

class Activate extends AbstractCommand
{
    protected $name = 'activate';

    public function __construct()
    {
        parent::__construct($this->name);
    }

    protected function process(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        try
        {
            $io->info('Run module activate');

            $controller = new ActivateController();
            $controller->execute();

            $io->success('Module activated successfully');
        }
        catch (\Exception $ex)
        {
            $io->error($ex->getMessage());
        }
    }

}