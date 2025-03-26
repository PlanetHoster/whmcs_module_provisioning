<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon\Deactivate;

use ModulesGarden\PlanetHoster\Core\Configuration\Addon\AbstractAfter;

/**
 * Runs after addon deactivation
 */
class After extends AbstractAfter
{
    /**
     * @param array $params
     * @return array
     */
    public function execute(array $params = [])
    {
        return $params;
    }
}
