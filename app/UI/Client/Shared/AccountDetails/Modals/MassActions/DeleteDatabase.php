<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\MassActions;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;
use ModulesGarden\PlanetHoster\Components\Modal\ModalDanger;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class DeleteDatabase extends ModalDanger implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->addElement(new Forms\MassActions\DeleteDatabase());
    }
}
