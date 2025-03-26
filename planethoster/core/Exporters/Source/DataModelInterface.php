<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters\Source;

interface DataModelInterface
{
    public function setCustomHeaders(array $headers);
    public function getHeaders(): array;
    public function getRowsCount():int;
    public function getContentData();
    public function getItemValuesByKey(int $key);
    public function getAsArray(): array;
}