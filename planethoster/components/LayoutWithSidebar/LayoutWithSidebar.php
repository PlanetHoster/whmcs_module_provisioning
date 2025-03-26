<?php

namespace ModulesGarden\PlanetHoster\Components\LayoutWithSidebar;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\CssContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\SizeTrait;

class LayoutWithSidebar extends AbstractComponent
{
    use SizeTrait;
    use CssContainerTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'LayoutWithSidebar';

    public function addSidebar($sidebar): self
    {
        $this->addComponent('sidebars', $sidebar);

        return $this;
    }

    public function clearSidebars(): self
    {
        $this->setSlot('sidebars', []);

        return $this;
    }

}