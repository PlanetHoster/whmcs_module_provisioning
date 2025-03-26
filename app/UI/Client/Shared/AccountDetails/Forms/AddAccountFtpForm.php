<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\FtpAccountsProvider;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\FormPasswordGenerator\FormPasswordGenerator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;

class AddAccountFtpForm extends Form implements AjaxComponentInterface,ClientAreaInterface
{
    protected string $provider = FtpAccountsProvider::class;
    protected string $providerAction = FtpAccountsProvider::ACTION_CREATE;

    public function __construct()
    {
        parent::__construct();
        $this->builder = BuilderCreator::oneColumn($this);
    }

    public function loadHtml(): void
    {
        $this->initFields();
    }

    public function initFields(): void
    {
        $field = new FormInputText();
        $field->required();
        $field->setPlaceholder($this->translate('username_placeholder'));
        $field->setName('user');
        $this->builder->addField($field);

        $field = new FormInputText();
        $field->setPlaceholder($this->translate('path_placeholder'));
        $field->setName('path');
        $this->builder->addField($field);

        $field = new FormPasswordGenerator();
        $field->required();
        $field->setName('password');
        $this->builder->addField($field);
    }
}



