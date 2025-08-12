<?php
namespace ModulesGarden\WhmcsModuleProvisioning\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\WhmcsModuleProvisioning\App\UI\Client\Shared\AccountDetails\Providers\AccountDetailsProvider;
use ModulesGarden\ModulesGardenBase\UI\Components\Forms\BaseForm;

class GenericActionForm extends BaseForm
{
    protected $providerAction;

    public function initContent()
    {
        $this->providerAction = $this->getRequestValue('providerAction') ?? $this->getData('providerAction');
        $this->setProviderAction($this->providerAction);
        // Ajoutez ici les champs dynamiques si besoin
    }
}
