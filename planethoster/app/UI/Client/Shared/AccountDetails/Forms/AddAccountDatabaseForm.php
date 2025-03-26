<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Forms;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\DatabaseAccountProvider;
use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\FormPasswordGenerator\FormPasswordGenerator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Components\FormInputGroup\FormInputGroup;
use ModulesGarden\PlanetHoster\Components\FormInputGroupLabel\FormInputGroupLabel;
use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;

class AddAccountDatabaseForm extends Form implements AjaxComponentInterface,ClientAreaInterface
{
    protected string $provider = DatabaseAccountProvider::class;
    protected string $providerAction = DatabaseAccountProvider::ACTION_CREATE;

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
        $serviceId = Request::get('id');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];
        
        $api = new PlanetHosterAPI(
            $serviceDetails['server']['hostname'],
            $serviceDetails['server']['username'],
            $serviceDetails['server']['password'],
            $serviceDetails['server']['prefix']
        );
        $results = $api->getInfoAccount($account_id);
        
        $dbName = (new FormInputGroup())->setName('database');
        $dbName->addElement((new FormInputGroupLabel)->setText($results['username'] . '_'));
        $dbName->addElement((new FormInputText)->setName('database'));
        $this->builder->addField($dbName);
        
        $dbUser = (new FormInputGroup())->setName('username');
        $dbUser->addElement((new FormInputGroupLabel)->setText($results['username'] . '_'));
        $dbUser->addElement((new FormInputText)->setName('username'));
        $this->builder->addField($dbUser);

        $field = new FormPasswordGenerator();
        $field->required();
        $field->setName('password');
        $this->builder->addField($field);

        $field = new Dropdown();
        $field->required();
        $field->setName('type');
        $field->setOptions([
                "MYSQL" => "MYSQL","POSTGRES" => "POSTGRES"
        ]);
        $this->builder->addField($field);

        $field = new Dropdown();
        $field->required();
        $field->setName('privileges');
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

    }
}



