<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms\MassActions;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\HiddenField\HiddenField;
use ModulesGarden\PlanetHoster\Components\Text\Text;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class DeleteEmail extends AbstractForm implements ClientAreaInterface, AjaxComponentInterface
{

    protected string $provider = Providers\EmailAccountProvider::class;
    protected string $providerAction = Providers\EmailAccountProvider::ACTION_MASS_DELETE;

    public function loadHtml(): void
    {
        $builder = BuilderCreator::simple($this);
        $builder->addElement((new Text())->setText($this->translate('confirmDelete')));
        $builder->createField(HiddenField::class, 'id');
    }
}
