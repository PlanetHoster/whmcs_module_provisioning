<?php

namespace ModulesGarden\PlanetHoster\Components\Card;

use ModulesGarden\PlanetHoster\Components\Button\Button;
use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Components\Icon\Icon;
use ModulesGarden\PlanetHoster\Core\Components\Enums\LayoutProps;

class CardButton extends Card
{
    public function setButton(Button $button): self
    {
        $this->addToToolbar($button->setLayoutProp(LayoutProps::FULL_WIDTH));

        return $this;
    }

    public function setIcon(string $icon): self
    {
        $iconContainer = new Container();
        //$iconContainer->setBorder(BorderColors::DANGER, BorderWidths::WIDTH_2);
        //$iconContainer->setBorderCircled();
        $iconContainer->addElement((new Icon())->setIcon($icon)->setContentCentered());
        $this->addToRightSidebar($iconContainer);

        return $this;
    }
}