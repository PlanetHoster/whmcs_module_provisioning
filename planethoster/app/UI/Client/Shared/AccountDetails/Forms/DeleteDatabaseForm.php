<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\DatabaseAccountProvider;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\HiddenField\HiddenField;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class DeleteDatabaseForm extends Form implements AjaxComponentInterface, ClientAreaInterface
{
    protected string $provider = DatabaseAccountProvider::class;
    protected string $providerAction = DatabaseAccountProvider::ACTION_DELETE;

    public function __construct()
    {
        parent::__construct();
        $this->builder = BuilderCreator::oneColumn($this);
    }

    public function loadHtml(): void
    {
        $builder = BuilderCreator::oneColumn($this);
        $builder->addElement((new HiddenField)->setName('database'));
    }
}
