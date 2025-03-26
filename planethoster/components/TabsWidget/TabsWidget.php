<?php

namespace ModulesGarden\PlanetHoster\Components\TabsWidget;

use ModulesGarden\PlanetHoster\Components\Tab\Tab;
use ModulesGarden\PlanetHoster\Components\Widget\Widget;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

/**
 * Class TabsWidget
 */
class TabsWidget extends Widget
{
    public const COMPONENT = 'TabsWidget';

    /**
     * @param ComponentInterface $component
     */
    public function addTab(Tab $component)
    {
        $this->addComponent('tabs', $component);
    }

    public function disableSwiper(bool $disableSwiper = true):self
    {
        $this->setSlot('disableSwiper', $disableSwiper);

        return $this;
    }
}
