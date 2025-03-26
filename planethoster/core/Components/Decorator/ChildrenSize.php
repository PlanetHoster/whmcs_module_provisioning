<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Decorator;

use ModulesGarden\PlanetHoster\Core\Components\Enums\DisplayTypes;

class ChildrenSize extends AbstractDecorator
{
    public function fitToParent(): self
    {
        return $this->appendClass(DisplayTypes::FLEX);
    }
}