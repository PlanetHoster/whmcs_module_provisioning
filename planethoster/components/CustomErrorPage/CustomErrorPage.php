<?php

namespace ModulesGarden\PlanetHoster\Components\CustomErrorPage;

use ModulesGarden\PlanetHoster\Components\BlockZeroData\BlockZeroData;
use ModulesGarden\PlanetHoster\Components\Button\ButtonPrimary;
use ModulesGarden\PlanetHoster\Core\Components\Actions\RedirectToPreviousPage;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class CustomErrorPage extends BlockZeroData implements ClientAreaInterface, AdminAreaInterface
{
    public function loadHtml(): void
    {
        $this->setTitle($this->getSlot('title', $this->translate('title')));
        $this->setDescription($this->getSlot('description',$this->translate('description')));

        $button = new ButtonPrimary();
        $button->setTitle($this->translate('return_button'));
        $button->onClick(new RedirectToPreviousPage());
        $this->addElement($button);
    }
}