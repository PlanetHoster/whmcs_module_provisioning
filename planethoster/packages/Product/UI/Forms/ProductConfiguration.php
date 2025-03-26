<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Forms;

use ModulesGarden\PlanetHoster\App\Http\Actions\MetaData;
use ModulesGarden\PlanetHoster\Components\Button\ButtonSuccess;
use ModulesGarden\PlanetHoster\Components\Container\ContainerContentCentered;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Components\Row\Row;
use ModulesGarden\PlanetHoster\Components\TableSimple\Record\Record;
use ModulesGarden\PlanetHoster\Components\TableSimple\TableSimple;
use ModulesGarden\PlanetHoster\Components\Widget\Widget;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Exceptions\UserException;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Support\Arr;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\Translation\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\ServersGroups;
use ModulesGarden\PlanetHoster\Packages\Product\Enums\ConfigSettings;
use ModulesGarden\PlanetHoster\Packages\Product\Libs\ConfigurableOptionsGroups\ConfigurableOptionsGroup;
use ModulesGarden\PlanetHoster\Packages\Product\UI\Formatters\ConfigOptionFullNameFormatter;
use ModulesGarden\PlanetHoster\Packages\Product\UI\Modals\CreateConfigurableOptions;
use ModulesGarden\PlanetHoster\Packages\Product\Helpers\ProductConfiguration as ProductConfigurationHelper;

class ProductConfiguration extends \ModulesGarden\PlanetHoster\Components\Form\AbstractForm implements AdminAreaInterface
{
    use TranslatorTrait;

    protected string $provider = \ModulesGarden\PlanetHoster\Packages\Product\UI\Providers\ProductConfiguration::class;

    public function preLoadHtml(): void
    {
        $this->checkServerRequirements();

        $this->builder = BuilderCreator::twoColumns($this);
        $this->setContainerTag('div');

        parent::preLoadHtml();
    }


    private function checkServerRequirements(): void
    {
        if (!Arr::get((new MetaData())->execute(), 'RequiresServer', false))
        {
            return;
        }

        $serverGroupId = Request::get('servergroup', false);

        if (!$serverGroupId)
        {
            throw new UserException($this->translate('productRequiresServer', [], ['packages.product.errors']));
        }

        $moduleName = ModuleConstants::getModuleName();

        if (ServersGroups::find($serverGroupId)->servers->where('type', $moduleName)->count() <= 0)
        {
            throw new UserException($this->translate('invalidServerType', ['moduleName' => $moduleName], ['packages.product.errors']));
        }
    }

    public function postLoadHtml(): void
    {
        parent::postLoadHtml();

        if (ProductConfigurationHelper::isRunAsProductAddon())
        {
            return;
        }

        $widget = new Widget();
        $widget->setTitle($this->translate('title', [], ['packages.product.productConfiguration.form']));

        $table = new TableSimple();

        $configurableOptions = is_callable(Config::get(ConfigSettings::CONFIG_OPTIONS_LOADER)) ? Config::get(ConfigSettings::CONFIG_OPTIONS_LOADER)(Request::get('id')) : Config::get(ConfigSettings::CONFIG_OPTIONS);

        foreach ($configurableOptions as $configOption)
        {
            if ($configOption instanceof ConfigurableOptionsGroup)
            {
                foreach ($configOption->getOptions() as $option)
                {
                    $table->addRecord(new Record([ConfigOptionFullNameFormatter::buildFullNameContainer($option->getFullName())]));
                }
                continue;
            }

            $table->addRecord(new Record([ConfigOptionFullNameFormatter::buildFullNameContainer($configOption->getFullName())]));
        }

        $widget->addElement($table);

        $button = new ButtonSuccess();
        $button->setTitle($this->translate('button_submit', [], ['packages.product.productConfiguration.form']));
        $button->onClick(new ModalLoad(new CreateConfigurableOptions()));

//        $container = new ContainerContentCentered();
//        $container->addElement($button);
//        $widget->addElement($container);

        //$this->addElement($widget);
    }
}