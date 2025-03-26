<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\AddAccountEmailButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\DeleteEmailAccountButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\MassActions\DeleteEmail;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Buttons\UpdateEmailAccountButton;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Switchers\StatusEmailAccount;
use ModulesGarden\PlanetHoster\Components\DataTable\DataTable;
use ModulesGarden\PlanetHoster\Components\DataTable\Column;
use ModulesGarden\PlanetHoster\Components\Text\Text;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\AbstractRecordsListDataProvider;
use ModulesGarden\PlanetHoster\Core\DataProviders\ArrayDataProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Components\FormLabel\FormLabel;

class Emails extends DataTable implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this
            ->addColumn((new Column('name'))
                ->setTitle($this->translate('name'))
                ->setSortable('ASC')
                ->setSearchable())
            ->addColumn((new Column('status'))
                ->setTitle($this->translate('status')))
            ->addColumn((new Column('quota'))
                ->setTitle($this->translate('quota'))
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

            if(!empty($account_id)) {

                $api = new PlanetHosterAPI(
                    $serviceDetails['server']['hostname'],
                    $serviceDetails['server']['username'],
                    $serviceDetails['server']['password'],
                    $serviceDetails['server']['prefix']
                );
                $results = $api->getEmailAccounts($account_id);

            }

        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $dataProv = new ArrayDataProvider();
        $dataProv->setData($results);
        $dataProv->setDefaultSorting('name', AbstractRecordsListDataProvider::SORT_ASC);
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
                $count = $api->getEmailAccounts($account_id, true);

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $text = new Text();
        $text->setText('<h5 style="margin-top:12.5px;"><b>'.$this->translate('email_accounts').' '.$count.'/'.$serviceDetails['productconfig']['max_email_account'].'</b></h5');
        $this->addToToolbar($text);

        $disabledButton = $count < $serviceDetails['productconfig']['max_email_account'] ? false : true;
        $this->addToToolbar((new AddAccountEmailButton())->setDisabled($disabledButton));
        $this->addActionButton(new UpdateEmailAccountButton());
        $this->addActionButton(new DeleteEmailAccountButton());
        $this->addMassActionButton(new DeleteEmail());

    }

    protected function parseDataSetRecords(): void
    {
        $this->dataSet->setFieldModifier('status', function($fieldName, $row, $fieldValue) {
            $label = new FormLabel();
            $label->addElement((new StatusEmailAccount())->setValue($fieldValue));

            return $label;
        });

        $this->dataSet->modifyRecords();
    }


}
