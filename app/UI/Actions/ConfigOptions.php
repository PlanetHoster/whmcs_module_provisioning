<?php

namespace ModulesGarden\PlanetHoster\App\UI\Actions;

use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;
use ModulesGarden\PlanetHoster\Components\Row\Row;
use ModulesGarden\PlanetHoster\Components\Switcher\Switcher;
use ModulesGarden\PlanetHoster\Components\Widget\Widget;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ProductConfiguration;
use ModulesGarden\PlanetHoster\Components\Alert\AlertDanger;

class ConfigOptions extends \ModulesGarden\PlanetHoster\Packages\Product\UI\Forms\ProductConfiguration
{
    public function loadHtml(): void
    {
        $this->generalSection();
    }

    protected function generalSection()
    {

        $productConfig = (new ProductConfiguration($_REQUEST['id']))->get();

        if(empty($productConfig['cpu']) || !is_numeric($productConfig['cpu']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'CPU'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['memory']) || !is_numeric($productConfig['memory']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'Memory'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['io']) || !is_numeric($productConfig['io']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'I/O bandwidth'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['email_quota']) || !is_numeric($productConfig['email_quota']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'Max quota'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['max_email_account']) || !is_numeric($productConfig['max_email_account']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'Max emails account'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['max_user_db']) || !is_numeric($productConfig['max_user_db']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'Max users database'));
            $this->builder->addElement($alert);
        }

        if(empty($productConfig['max_ftp_account']) || !is_numeric($productConfig['max_ftp_account']))
        {
            $alert = new AlertDanger();
            $alert->setText(sprintf($this->translate('errorConfiguration'), 'Max FTP account'));
            $this->builder->addElement($alert);
        }

        if($productConfig['cpu'] < 1 || $productConfig['cpu'] > 8)
        {
            $alert = new AlertDanger();
            $alert->setText($this->translate('errorCPUValue'));
            $this->builder->addElement($alert);
        }

        if($productConfig['io'] < 1 || $productConfig['io'] > 24)
        {
            $alert = new AlertDanger();
            $alert->setText($this->translate('errorIOValue'));
            $this->builder->addElement($alert);
        }

        if($productConfig['memory'] < 1 || $productConfig['memory'] > 24)
        {
            $alert = new AlertDanger();
            $alert->setText($this->translate('errorMemValue'));
            $this->builder->addElement($alert);
        }


        $row = new Row();

        $generalSection2 = new Widget();
        $generalSection2->setTitle($this->translate('title'));
        $generalSection2->addElement($row);

        $this->builder->addFieldInContainer($row, (new Switcher())->setName('customconfigoption[ls]'));

        $this->builder->addFieldInContainer($row, (new Dropdown())->setName('customconfigoption[country]')
            ->setOptions(['CA' => 'CA', 'FR' => 'FR'])->setDefaultValueAsFirstOption());

        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[cpu]')->setDefaultValue('2'));
        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[memory]')->setDefaultValue('4'));
        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[io]')->setDefaultValue('2'));

        $this->builder->addFieldInContainer($row, (new Dropdown())->setName('customconfigoption[cms_name]')
            ->setOptions(['' => 'None','wp' => 'Wordpress', 'joomla' => 'Joomla', 'prestashop' => 'Prestashop', 'drupal' => 'Drupal'])->setDefaultValueAsFirstOption());

        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[email_quota]')->setDefaultValue('200'));
        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[max_email_account]')->setDefaultValue('10'));
        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[max_user_db]')->setDefaultValue('10'));
        $this->builder->addFieldInContainer($row, (new FormInputText())->setName('customconfigoption[max_ftp_account]')->setDefaultValue('10'));

        $this->builder->addElement($generalSection2);
    }
}