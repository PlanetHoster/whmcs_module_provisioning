<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon;

/**
 * Description of AbstractAfter
 */
abstract class AbstractAfter
{
    public function __construct()
    {
    }

    abstract public function execute(array $params = []);
}
