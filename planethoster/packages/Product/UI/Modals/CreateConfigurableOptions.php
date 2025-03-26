<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Modals;

use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Packages\Product\Enums\ConfigSettings;

class CreateConfigurableOptions extends ModalEdit implements AdminAreaInterface, AjaxComponentInterface
{
    public function loadHtml(): void
    {
        $this->setSize(Config::get(ConfigSettings::CONFIG_OPTIONS_MODAL_SIZE, ""));
        $this->addElement(new \ModulesGarden\PlanetHoster\Packages\Product\UI\Forms\CreateConfigurableOptions());
    }
}