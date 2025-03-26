<?php

namespace ModulesGarden\PlanetHoster\App\UI\Admin\Home\Index;

use ModulesGarden\PlanetHoster\Components\Alert\Alert;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;

class Container extends \ModulesGarden\PlanetHoster\Components\Container\Container implements AdminAreaInterface
{
    public function loadHtml(): void
    {
        $alert = new Alert();
        $alert->setText($this->translate("Hello!"));
        $this->addElement($alert);
    }
}