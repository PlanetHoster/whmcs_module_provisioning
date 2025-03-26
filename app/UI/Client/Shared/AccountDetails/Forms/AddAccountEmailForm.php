<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\EmailAccountProvider;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\FormInputGroup\FormInputGroup;
use ModulesGarden\PlanetHoster\Components\FormInputGroupLabel\FormInputGroupLabel;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\FormPasswordGenerator\FormPasswordGenerator;
use ModulesGarden\PlanetHoster\Components\HiddenField\HiddenField;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service;

class AddAccountEmailForm extends Form implements AjaxComponentInterface,ClientAreaInterface
{
    protected string $provider = EmailAccountProvider::class;
    protected string $providerAction = EmailAccountProvider::ACTION_CREATE;

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
        $service = Service::find($_REQUEST['id']);

        $loginGroup = (new FormInputGroup())->setName('username');
        $loginGroup->addElement((new FormInputText)->setName('username'));
        $loginGroup->addElement((new FormInputGroupLabel)->setText('@'));
        $loginGroup->addElement((new FormInputText())->setValue($service->domain)->setName('domain')->setReadOnly());
        $this->builder->addField($loginGroup);

        $field = new FormPasswordGenerator();
        $field->required();
        $field->setName('password');
        $this->builder->addField($field);

        $field = new FormInputText();
        $field->numeric();
        $field->required();
        $field->setPlaceholder($this->translate('quota_placeholder'));
        $field->setName('quota');
        $this->builder->addField($field);

        $field = new HiddenField();
        $field->setName('domain');
        $field->setValue($service->domain);
        $this->builder->addField($field);

    }
}
