<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Providers;

use ModulesGarden\PlanetHoster\Core\DataProviders\CrudProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product;
use ModulesGarden\PlanetHoster\Packages\Product\Enums\ConfigSettings;
use ModulesGarden\PlanetHoster\Packages\Product\Libs\ConfigurableOptions\AbstractConfigurableOption;
use ModulesGarden\PlanetHoster\Packages\Product\Libs\ConfigurableOptionsGroups\ConfigurableOptionsGroup;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ConfigurableOptions;

class CreateConfigurableOptions extends CrudProvider
{
    public function create()
    {
        $product        = Product::findOrFail(Request::get('id'));
        $productService = new ConfigurableOptions($product);

        foreach ($this->getAllConfigurableOptions() as $configOption)
        {
            /**
             * @var $configOption AbstractConfigurableOption
             */
            if ($this->formData->get($configOption->getName(), false))
            {
                $productService->createConfigurableOption($configOption);
            }
        }
    }

    protected function getAllConfigurableOptions(): array
    {
        $configurableOptionsFromConfig = is_callable(Config::get(ConfigSettings::CONFIG_OPTIONS_LOADER)) ?
            Config::get(ConfigSettings::CONFIG_OPTIONS_LOADER)(Request::get('id')) :
            Config::get(ConfigSettings::CONFIG_OPTIONS);

        $configurableOptions = [];

        foreach ($configurableOptionsFromConfig as $configOption)
        {
            if ($configOption instanceof ConfigurableOptionsGroup)
            {
                $configurableOptions = array_merge($configurableOptions, $configOption->getOptions());
                continue;
            }
            $configurableOptions[] = $configOption;
        }

        return $configurableOptions;
    }
}