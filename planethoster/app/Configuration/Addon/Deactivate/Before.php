<?php

namespace ModulesGarden\PlanetHoster\App\Configuration\Addon\Deactivate;

/**
 * Runs before addon deactivation
 */
class Before extends \ModulesGarden\PlanetHoster\Core\Configuration\Addon\Deactivate\Before
{
    /**
     * @param array $params
     * @return array
     */
    public function execute(array $params = [])
    {
        $return = parent::execute($params);

        return $return;
    }
}
