<?php

namespace ModulesGarden\PlanetHoster\Core\UI\PageParams\ModuleActions;

use ModulesGarden\PlanetHoster\Core\UI\PageParams\Source\ModuleActionInterface;

class ClientArea implements ModuleActionInterface
{

    public function selectAppropriateParameters(array $params): array
    {
        if (!empty($params['serviceid']))
        {
            return ['id' => $params['serviceid']];
        }

        return [];
    }
}