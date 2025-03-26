<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\AddAccountEmailModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonSuccess;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;

class AddAccountEmailButton extends ButtonSuccess
{
    public function loadHtml(): void
    {
        $this->onClick(new ModalLoad(new AddAccountEmailModal()));
    }

}
