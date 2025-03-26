<?php

namespace ModulesGarden\PlanetHoster\Components\BlockError;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;

class BlockError extends Container implements ClientAreaInterface, AdminAreaInterface
{
    public const COMPONENT = 'BlockError';

    public function setException(\Throwable $exception)
    {
        $this->setSlot('error', $exception->getMessage());

        if (Config::get('configuration.debug', false))
        {
            $this->setSlot('file', $exception->getFile());
            $this->setSlot('line', $exception->getLine());
            $this->setSlot('trace', $exception->getTraceAsString());
        }
    }
}
