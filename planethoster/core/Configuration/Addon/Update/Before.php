<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update;

use ModulesGarden\PlanetHoster\Core\Configuration\Addon\AbstractBefore;

/**
 * runs after module update actions
 */
class Before extends AbstractBefore
{
    /**
     * @return array
     */
    public function execute($version)
    {
        return [];
    }
}
