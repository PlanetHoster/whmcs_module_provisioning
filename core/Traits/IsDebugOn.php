<?php

namespace ModulesGarden\PlanetHoster\Core\Traits;

use ModulesGarden\PlanetHoster\Core\ServiceLocator;

/**
 * Description of IsDebugOn
 *
 * @deprecated
 */
trait IsDebugOn
{
    public function isDebugOn()
    {
        return \ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('configuration.debug');
    }
}
