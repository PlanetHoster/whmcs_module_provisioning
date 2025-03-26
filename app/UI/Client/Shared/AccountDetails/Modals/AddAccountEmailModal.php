<?php
namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\AddAccountEmailForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class AddAccountEmailModal extends ModalEdit implements AjaxComponentInterface,ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->addElement(new AddAccountEmailForm());
    }
}

