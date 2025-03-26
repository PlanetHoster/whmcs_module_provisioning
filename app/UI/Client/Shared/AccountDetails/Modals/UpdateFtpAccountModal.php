<?php
namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\UpdateFtpAccountForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class UpdateFtpAccountModal extends ModalEdit implements AjaxComponentInterface,ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->addElement(new UpdateFtpAccountForm());
    }
}

