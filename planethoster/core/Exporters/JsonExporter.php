<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters;

class JsonExporter extends BaseExporter
{
    public function get(): string
    {
        return json_encode($this->dataSet->getAsArray());
    }
}