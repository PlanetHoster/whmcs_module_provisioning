<?php
namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Modals;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\GenericActionForm;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Components\Button\ButtonSuccess;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalFormSubmit;

class ConfirmActionModal extends ModalEdit implements AjaxComponentInterface, ClientAreaInterface
{
    protected $actionName;
    protected $confirmationText;
    protected $titleText;

    public function __construct($actionName, $titleText, $confirmationText)
    {
        parent::__construct();
        $this->actionName = $actionName;
        $this->confirmationText = $confirmationText;
        $this->titleText = $titleText;
    }

    public function loadHtml(): void
    {
        $this->setTitle($this->titleText);
        $this->setContent($this->confirmationText);
        $form = new GenericActionForm();
        $form->setData('providerAction', $this->actionName);
        $this->addElement($form);
    }
}