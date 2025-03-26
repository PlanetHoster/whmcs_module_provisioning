<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters\DataModels;

use ModulesGarden\PlanetHoster\Core\Exporters\Source\BaseDataModel;
use ModulesGarden\PlanetHoster\Core\Exporters\Source\DataModelInterface;
use \Illuminate\Database\Eloquent\Collection as CollectionModel;

class Collection extends BaseDataModel implements DataModelInterface
{
    protected CollectionModel $collection;

    public function __construct(CollectionModel $collection)
    {
        $this->collection = $collection;
    }

    public function getHeaders():array
    {
        return parent::combineHeaders(array_keys($this->collection->first()->getAttributes()));
    }

    public function getAsArray(): array
    {
        return $this->collection->toArray();
    }

    public function getRowsCount(): int
    {
        return $this->collection->count();
    }

    public function getContentData()
    {
        return $this->collection;
    }

    public function getItemValuesByKey(int $key)
    {
        return $this->collection->get($key)->getAttributes();
    }
}