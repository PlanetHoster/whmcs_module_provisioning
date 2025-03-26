<?php

namespace ModulesGarden\PlanetHoster\Core\CommandLine;

use ModulesGarden\PlanetHoster\Packages\CommandLine\Hypervisor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 */
class Command extends AbstractCommand
{
    final protected function configure()
    {
        parent::configure();
    }

    /**
     * Execute command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    final protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return parent::execute($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \Exception
     */
    protected function beforeProcess(InputInterface $input, OutputInterface $output)
    {
        (new Hypervisor($this->getName(), $input->getOptions()))
            ->lock();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function afterProcess(InputInterface $input, OutputInterface $output)
    {
        (new Hypervisor($this->getName(), $input->getOptions()))
            ->unlock();
    }
}
