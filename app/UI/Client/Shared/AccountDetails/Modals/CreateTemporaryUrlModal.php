<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\CreateTemporaryUrlForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class CreateTemporaryUrlModal extends ModalEdit implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->setTitle($this->translate('title'));
        $this->setContent($this->translate('confirm'));
        $this->addElement(new CreateTemporaryUrlForm());
    }
}
