<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\UpdateEmailAccountModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonPrimary;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;

class UpdateEmailAccountButton extends ButtonPrimary
{
    public function loadHtml(): void
    {
        $this->onClick(new ModalLoad(new UpdateEmailAccountModal()));
    }

}
