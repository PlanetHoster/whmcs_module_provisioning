<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon\Activate;

use ModulesGarden\PlanetHoster\Core\Configuration\Addon\AbstractBefore;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\ServiceLocator;

/**
 * Runs before module activation actions
 */
class Before extends AbstractBefore
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
