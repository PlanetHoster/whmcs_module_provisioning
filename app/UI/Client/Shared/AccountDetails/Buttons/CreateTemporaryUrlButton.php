<?php
namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\CreateTemporaryUrlModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonWarning;
use ModulesGarden\PlanetHoster\Core\Components\Action;

class CreateTemporaryUrlButton extends ButtonWarning
{
    public function loadHtml(): void
    {
        $this->onClick(Action::modalOpen(new CreateTemporaryUrlModal()));
    }
}