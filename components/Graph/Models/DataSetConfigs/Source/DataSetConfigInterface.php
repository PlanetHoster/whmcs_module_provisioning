<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Models\DataSetConfigs\Source;

interface DataSetConfigInterface
{
    public function getName(): string;
    public function getValue();
}