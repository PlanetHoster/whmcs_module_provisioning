<?php

namespace ModulesGarden\PlanetHoster\Core\Cron;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon\Deactivate as DeactivateController;
use ModulesGarden\PlanetHoster\Core\CommandLine\AbstractCommand;
use ModulesGarden\PlanetHoster\Core\Database\DatabaseManager;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Input\InputOption;
use \Symfony\Component\Console\Output\OutputInterface;
use \Symfony\Component\Console\Style\SymfonyStyle;

class Deactivate extends AbstractCommand
{
    protected const REMOVE_DATABASE_TABLES_OPTION = "remove-database-tables";

    protected $name = 'deactivate';

    public function __construct()
    {
        parent::__construct($this->name);
    }

    protected function setup()
    {
        $this->addOption(self::REMOVE_DATABASE_TABLES_OPTION, null, InputOption::VALUE_OPTIONAL, "Remove Data Tables");
    }

    protected function process(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        try
        {
            $io->info('Run module deactivate');

            $controller = new DeactivateController();
            $controller->execute();

            if ($input->hasParameterOption("--" . self::REMOVE_DATABASE_TABLES_OPTION))
            {
                $this->askAndRemoveDataBaseTables($input, $output, $io);
            }

            $io->success('Module deactivated successfully');
        }
        catch (\Exception $ex)
        {
            $io->error($ex->getMessage());
        }
    }

    protected function askAndRemoveDataBaseTables(InputInterface $input, OutputInterface $output, SymfonyStyle $io)
    {
        if ($io->confirm("Are you absolutely sure you want to drop all database tables?", false))
        {
            (new DatabaseManager())->dropAllModuleTables();

            $io->success('Database tables dropped successfully');
        }
    }

}