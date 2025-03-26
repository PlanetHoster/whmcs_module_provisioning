<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\GroupBuilders;

use ModulesGarden\PlanetHoster\Components\Form\Builder\GroupBuilders\DefaultBuilder;
use ModulesGarden\PlanetHoster\Packages\Product\UI\FieldFactories\ConfigOptionSwitcherFactory;

class ConfigOptionSwitcherBuilder extends DefaultBuilder
{
    protected function findBuilder($name): string
    {
        return ConfigOptionSwitcherFactory::class;
    }
}