<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\GenericProvider;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
// use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
// use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class GenericForm extends Form //implements AjaxComponentInterface, ClientAreaInterface
{
    public function initContent()
    {
        $providerAction = $this->getRequestValue('providerAction');
        if ($providerAction) {
            $this->setProviderAction($providerAction);
        }
        // Ajout des champs ici
    }

    public function loadHtml(): void
    {
        $builder = BuilderCreator::oneColumn($this);
    }
}
