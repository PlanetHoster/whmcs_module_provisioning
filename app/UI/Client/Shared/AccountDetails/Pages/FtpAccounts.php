<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\AddAccountFtpButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\DeleteFtpAccountButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\UpdateFtpAccountButton;
use ModulesGarden\PlanetHoster\Components\DataTable\DataTable;
use ModulesGarden\PlanetHoster\Components\DataTable\Column;
use ModulesGarden\PlanetHoster\Components\Text\Text;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\AbstractRecordsListDataProvider;
use ModulesGarden\PlanetHoster\Core\DataProviders\ArrayDataProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\MassActions\DeleteFtp;

class FtpAccounts extends DataTable implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this
            ->addColumn((new Column('username'))
                ->setTitle($this->translate('username'))
                ->setSortable('ASC')
                ->setSearchable())
            ->addColumn((new Column('path'))
                ->setTitle($this->translate('path'))
                ->setSortable('ASC'));
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
                $results = $api->getFtpAccounts($account_id);

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $dataProv = new ArrayDataProvider();
        $dataProv->setData($results);
        $dataProv->setDefaultSorting('username', AbstractRecordsListDataProvider::SORT_ASC);
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
                $count = $api->getFtpAccounts($account_id, true);

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $text = new Text();
        $text->setText('<h5 style="margin-top:12.5px;"><b>'.$this->translate('ftp_accounts').' '.$count.'/'.$serviceDetails['productconfig']['max_ftp_account'].'</b></h5');
        $this->addToToolbar($text);

        $disabledButton = $count < $serviceDetails['productconfig']['max_ftp_account'] ? false : true;
        $this->addToToolbar((new AddAccountFtpButton())->setDisabled($disabledButton));
        $this->addActionButton(new UpdateFtpAccountButton());
        $this->addActionButton(new DeleteFtpAccountButton());
        
        $this->addMassActionButton(new DeleteFtp());
    }

}
