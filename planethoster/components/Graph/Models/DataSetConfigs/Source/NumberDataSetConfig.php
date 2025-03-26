<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Models\DataSetConfigs\Source;

abstract class NumberDataSetConfig extends AbstractDataSetConfig
{
    public function __construct(int $value)
    {
        $this->value = $value;
    }
}