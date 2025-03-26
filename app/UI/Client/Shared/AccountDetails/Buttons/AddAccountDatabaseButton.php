<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\AddAccountDatabaseModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonSuccess;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;

class AddAccountDatabaseButton extends ButtonSuccess
{
    public function loadHtml(): void
    {
        $this->onClick(new ModalLoad(new AddAccountDatabaseModal()));
    }

}
