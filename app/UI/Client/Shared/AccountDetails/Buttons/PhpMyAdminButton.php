<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\PhpMyAdminModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonWarning;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;
use ModulesGarden\PlanetHoster\Core\Components\Action;

class PhpMyAdminButton extends ButtonWarning
{
    public function loadHtml(): void
    {
        $this->onClick(Action::modalOpen(new PhpMyAdminModal()));
    }

}
