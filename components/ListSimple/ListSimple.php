<?php

namespace ModulesGarden\PlanetHoster\Components\ListSimple;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\CssContainerTrait;

class ListSimple extends AbstractComponent
{
    use ComponentsContainerTrait;

    public const COMPONENT = 'ListSimple';

    public function addItem($item): self
    {
        $this->addElement($item);

        return $this;
    }
}
