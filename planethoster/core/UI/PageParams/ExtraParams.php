<?php

namespace ModulesGarden\PlanetHoster\Core\UI\PageParams;

use ModulesGarden\PlanetHoster\Core\Support\Facades\Params;

class ExtraParams
{
    public static function getForCurrentAction():array
    {
        $params = Params::all();

        $moduleAction = ModuleActionsFactory::getFromParams($params);

        return $moduleAction->selectAppropriateParameters($params);
    }
}
