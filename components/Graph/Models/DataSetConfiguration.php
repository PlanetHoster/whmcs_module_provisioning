<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Models;

use Illuminate\Contracts\Support\Arrayable;
use ModulesGarden\PlanetHoster\Components\Graph\Models\DataSetConfigs\Source\DataSetConfigInterface;

class DataSetConfiguration implements Arrayable
{
    protected array $configs = [];

    public function addConfiguration(DataSetConfigInterface $dataSetConfigInterface):self
    {
        array_push($this->configs, $dataSetConfigInterface);

        return $this;
    }

    public function toArray()
    {
        $configurations = [];

        foreach ($this->configs as $config)
        {
            /**
             * @var $column DataSetConfigInterface
             */
            $configurations[$config->getName()] = $config->getValue();
        }

        return $configurations;
    }
}