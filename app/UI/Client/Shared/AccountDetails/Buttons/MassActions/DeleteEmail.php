<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\MassActions;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;
use ModulesGarden\PlanetHoster\Components\IconButton\IconButtonDelete;
use ModulesGarden\PlanetHoster\Core\Components\Action;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class DeleteEmail extends IconButtonDelete implements ClientAreaInterface
{
    public function loadHtml(): void
    {
        parent::loadHtml();

        $this->displayWithTitle($this->translate('DeleteMassEmail'));
        $this->onClick(Action::modalOpen(new Modals\MassActions\DeleteEmail()));
    }
}
