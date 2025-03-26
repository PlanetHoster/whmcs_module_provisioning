<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\DeleteDatabaseModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonDanger;
use ModulesGarden\PlanetHoster\Core\Components\Action;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class DeleteDatabaseButton extends ButtonDanger implements ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->onClick(Action::modalOpen(new DeleteDatabaseModal()));
    }
}
