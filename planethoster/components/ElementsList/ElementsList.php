<?php

namespace ModulesGarden\PlanetHoster\Components\ElementsList;

use ModulesGarden\PlanetHoster\Components\DataTable\DataTable;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;

abstract class ElementsList extends DataTable
{
    public const COMPONENT = 'ElementsList';

    abstract protected function buildElement($record):AbstractComponent;

    protected function parseDataSetRecords(): void
    {
        foreach ($this->dataSet->getRecords() as $record)
        {
            $this->addElement($this->buildElement($record));
        }
    }
}