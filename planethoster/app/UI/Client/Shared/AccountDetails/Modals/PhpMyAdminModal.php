<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\PhpMyAdminForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class PhpMyAdminModal extends ModalEdit implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->setTitle($this->translate('title'));
        $this->setContent($this->translate('phpmyadmin'));
        $this->addElement(new PhpMyAdminForm());
    }
}
