<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update;

use ModulesGarden\PlanetHoster\Core\Configuration\Addon\AbstractAfter;

/**
 * runs after module update actions
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
