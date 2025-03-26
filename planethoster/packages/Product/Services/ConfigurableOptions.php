<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Services;

use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOption;
use ModulesGarden\PlanetHoster\Packages\Product\Libs\ConfigurableOptions\AbstractConfigurableOption;

class ConfigurableOptions
{
    protected $configOptions = null;
    protected Product $product;
    protected ConfigurableOptionsGroup $configurableOptionsGroupService;

    public function __construct(Product $product)
    {
        $this->product                         = $product;
        $this->configurableOptionsGroupService = new ConfigurableOptionsGroup();
    }

    public function createConfigurableOption(AbstractConfigurableOption $configurableOption)
    {
        if ($this->hasConfigurableOption($configurableOption->getName()))
        {
            return;
        }

        $group = $this->configurableOptionsGroupService->getFirstOrCreateRelated($this->product);
        $configurableOption->setGroupId($group->id);
        $configurableOption->create($this->product);
    }

    protected function hasConfigurableOption($optionName = null): bool
    {
        if (!is_string($optionName) || trim($optionName) === '')
        {
            return false;
        }

        $rawOptionName = $this->configOptionNameToRaw($optionName);
        $this->loadConfigOptions();

        foreach ($this->configOptions as $option)
        {
            if ($rawOptionName === $this->configOptionNameToRaw($option->optionname))
            {
                return true;
            }
        }

        return false;
    }

    protected function configOptionNameToRaw($optionName): string
    {
        return explode('|', (string)$optionName)[0];
    }

    protected function loadConfigOptions($force = false)
    {
        if ($force || $this->configOptions === null)
        {
            $this->configOptions = ProductConfigOption::ofProductId($this->product->id)->get();
        }
    }

    public function getConfigurableOptionByName(string $optionName)
    {
        if (trim($optionName) === '')
        {
            return null;
        }

        $rawOptionName = $this->configOptionNameToRaw($optionName);
        $this->loadConfigOptions();

        foreach ($this->configOptions as $option)
        {
            if ($rawOptionName === $this->configOptionNameToRaw($option->optionname))
            {
                return $option;
            }
        }

        return null;
    }
}