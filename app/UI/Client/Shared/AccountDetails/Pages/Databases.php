<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\AddAccountDatabaseButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\DeleteDatabaseButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\PhpMyAdminButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\UpdateDatabaseButton;
use ModulesGarden\PlanetHoster\Components\DataTable\DataTable;
use ModulesGarden\PlanetHoster\Components\DataTable\Column;
use ModulesGarden\PlanetHoster\Components\Text\Text;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\ArrayDataProvider;
use ModulesGarden\PlanetHoster\Core\DataProviders\AbstractRecordsListDataProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\MassActions\DeleteDatabase;


class Databases extends DataTable implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this
            ->addColumn((new Column('database'))
                ->setTitle($this->translate('database'))
                ->setSortable('ASC')
                ->setSearchable())
            ->addColumn((new Column('username'))
                ->setTitle($this->translate('username'))
                ->setSortable('ASC')
                ->setSearchable());
        $this->initComponents();
    }

    public function loadData(): void
    {
        $results = [];

        $serviceId = Request::get('id');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];

        try {
            if (!empty($account_id)) {

                $api = new PlanetHosterAPI(
                    $serviceDetails['server']['hostname'],
                    $serviceDetails['server']['username'],
                    $serviceDetails['server']['password'],
                    $serviceDetails['server']['prefix']
                );
                $results = $api->getDatabases($account_id);

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $dataProv = new ArrayDataProvider();
        $dataProv->setData($results);
        $dataProv->setDefaultSorting('database', AbstractRecordsListDataProvider::SORT_ASC);
        $this->setDataProvider($dataProv);
    }


    public function initComponents(): void
    {
        $count = 0;

        $serviceId = Request::get('id');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];

        try {
            if (!empty($account_id)) {

                $api = new PlanetHosterAPI(
                    $serviceDetails['server']['hostname'],
                    $serviceDetails['server']['username'],
                    $serviceDetails['server']['password'],
                    $serviceDetails['server']['prefix']
                );
                $count = $api->getDatabases($account_id, true);

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $text = new Text();
        $text->setText('<h5 style="margin-top:12.5px;"><b>'.$this->translate('databases').' '.$count.'/'.$serviceDetails['productconfig']['max_user_db'].'</b></h5');
        $this->addToToolbar($text);

        $disabledButton = $count < $serviceDetails['productconfig']['max_user_db'] ? false : true;
        $this->addToToolbar((new AddAccountDatabaseButton())->setDisabled($disabledButton));
        $this->addActionButton(new PhpMyAdminButton());
        $this->addActionButton(new UpdateDatabaseButton());
        $this->addActionButton(new DeleteDatabaseButton());
        
        $this->addMassActionButton(new DeleteDatabase());
    }

}