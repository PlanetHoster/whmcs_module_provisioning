<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Buttons;

use ModulesGarden\PlanetHoster\Components\Button\ButtonInfo;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Packages\Product\UI\Modals;

class ServerConfiguration extends ButtonInfo implements AdminAreaInterface
{
    public function loadHtml(): void
    {
        $this->setTitle($this->translate('button.title'));
        $this->setIcon('settings');
        $this->onClick((new ModalLoad(new Modals\ServerConfiguration())));
    }
}