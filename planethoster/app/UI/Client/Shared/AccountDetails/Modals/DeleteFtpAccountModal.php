<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\DeleteFtpAccountForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalDanger;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class DeleteFtpAccountModal extends ModalDanger implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->setTitle($this->translate('title'));
        $this->setContent($this->translate('deleteProduct'));
        $this->addElement(new DeleteFtpAccountForm());
    }
}
