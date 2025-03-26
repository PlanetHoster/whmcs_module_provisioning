<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters\DataModels;

use ModulesGarden\PlanetHoster\Core\Exporters\Source\BaseDataModel;
use ModulesGarden\PlanetHoster\Core\Exporters\Source\DataModelInterface;

class ArrayData extends BaseDataModel implements DataModelInterface
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getHeaders():array
    {
        return parent::combineHeaders($this->data[0]);
    }

    public function getRowsCount():int
    {
        return count($this->data) - 1;
    }

    public function getItemValuesByKey(int $key)
    {
        return $this->data[$key];
    }

    public function getContentData()
    {
        $data = $this->data;
        unset($data[0]);
        return $data;
    }

    public function getAsArray(): array
    {
        return $this->data;
    }
}