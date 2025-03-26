<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Models\DataSetConfigs\Source;

abstract class StringDataSetConfig extends AbstractDataSetConfig
{
    public function __construct(bool|string $value)
    {
        $this->value = $value;
    }
}