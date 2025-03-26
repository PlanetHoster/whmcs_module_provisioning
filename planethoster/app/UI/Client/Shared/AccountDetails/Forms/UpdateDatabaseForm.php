<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\DatabaseAccountProvider;
use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\FormPasswordGenerator\FormPasswordGenerator;
use ModulesGarden\PlanetHoster\Components\HiddenField\HiddenField;
use ModulesGarden\PlanetHoster\Components\TextArea\TextArea;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service;
use ModulesGarden\PlanetHoster\Components\FormInputGroup\FormInputGroup;
use ModulesGarden\PlanetHoster\Components\FormInputGroupLabel\FormInputGroupLabel;

class UpdateDatabaseForm extends Form implements AjaxComponentInterface,ClientAreaInterface
{
    protected string $provider = DatabaseAccountProvider::class;
    protected string $providerAction = DatabaseAccountProvider::ACTION_UPDATE;

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
        $user = explode('_', $_REQUEST['formData']['username']);
        
        $field = new HiddenField();
        $field->setName('database');
        $this->builder->addField($field);
        
        $dbUser = (new FormInputGroup())->setName('username_new');
        $dbUser->addElement((new FormInputGroupLabel)->setText($user[0] . '_'));
        $dbUser->addElement((new FormInputText)->setName('username_new')->setValue($user[1]));
        $this->builder->addField($dbUser);

        $field = new FormPasswordGenerator();
        $field->setName('password');
        $this->builder->addField($field);

        $field = new Dropdown();
        $field->required();
        $field->setName('permissions');
        $field->setOptions([
            "ALL PRIVILEGES" => "ALL PRIVILEGES",
            "ALTER" => "ALTER",
            "ALTER ROUTINE" => "ALTER ROUTINE",
            "CREATE" => "CREATE",
            "CREATE ROUTINE" => "CREATE ROUTINE",
            "CREATE TEMPORARY TABLES" => "CREATE TEMPORARY TABLES",
            "CREATE VIEW" => "CREATE VIEW",
            "DELETE" => "DELETE",
            "DROP" => "DROP",
            "EVENT" => "EVENT",
            "EXECUTE" => "EXECUTE",
            "INDEX" => "INDEX",
            "INSERT" => "INSERT",
            "LOCK TABLES" => "LOCK TABLES",
            "REFERENCES" => "REFERENCES",
            "SELECT" => "SELECT",
            "SHOW VIEW" => "SHOW VIEW",
            "TRIGGER" => "TRIGGER",
            "UPDATE" => "UPDATE"
        ]);
        $field->setMultiple(true);
        $this->builder->addField($field);

        $field = new HiddenField();
        $field->setName('domain');
        $field->setValue($service->domain);
        $this->builder->addField($field);
    }
}