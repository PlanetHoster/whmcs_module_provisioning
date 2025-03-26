<?php

namespace ModulesGarden\PlanetHoster\Core\UI\PageParams\ModuleActions;

use ModulesGarden\PlanetHoster\Core\UI\PageParams\Source\ModuleActionInterface;

class DefaultAction implements ModuleActionInterface
{

    public function selectAppropriateParameters(array $params): array
    {
        return [];
    }
}