<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\EmailAccountProvider;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\FormPasswordGenerator\FormPasswordGenerator;
use ModulesGarden\PlanetHoster\Components\HiddenField\HiddenField;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service;

class UpdateEmailAccountForm extends Form implements AjaxComponentInterface,ClientAreaInterface
{
    protected string $provider = EmailAccountProvider::class;
    protected string $providerAction = EmailAccountProvider::ACTION_UPDATE;

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

        $field = new HiddenField();
        $field->setName('email');
        $this->builder->addField($field);

        $field = new FormPasswordGenerator();
        $field->setName('password');
        $this->builder->addField($field);

        $field = new FormInputText();
        $field->setPlaceholder($this->translate('quota_placeholder'));
        $field->setName('quota');
        $this->builder->addField($field);

        $field = new HiddenField();
        $field->setName('domain');
        $field->setValue($service->domain);
        $this->builder->addField($field);
    }
}