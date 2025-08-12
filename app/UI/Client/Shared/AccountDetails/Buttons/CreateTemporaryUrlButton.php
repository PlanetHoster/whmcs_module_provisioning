<?php
namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals\ConfirmActionModal;
use ModulesGarden\PlanetHoster\Components\Button\ButtonWarning;
use ModulesGarden\PlanetHoster\Core\Components\Action;

class CreateTemporaryUrlButton extends ButtonWarning
{
    public function loadHtml(): void
    {
        $modal = new ConfirmActionModal('CreateTemporaryUrl',$this->translate('title'), $this->translate('confirm'));
        $this->onClick(Action::modalOpen($modal));
        $this->setTitle($this->translate('title'));
    }
}