<?php

namespace ModulesGarden\PlanetHoster\Core\DataProviders;

use Illuminate\Support\Collection;
use ModulesGarden\PlanetHoster\Core\Contracts\DataSetInterface;

class ArrayDataProvider extends AbstractRecordsListDataProvider //implements QueryProviderInterface
{
    private $collection = null;
    private $fullDataLength = 0;

    public function __construct($records = [])
    {
        $this->setData($records);
    }

    public function setData($records)//:// QueryProviderInterface
    {
        $this->collection = new \Illuminate\Support\Collection($records);

        return $this;
    }

    public function getData()/*: \ModulesGarden\PlanetHoster\Core\Contracts\DataSetInterface*/
    {
        $this->avalibleCols = [];

        $this->setupSearch();
        $this->setupSorting();
        $this->countRawResults();
        $this->setupLimit();

        return $this->getResults();
    }

    protected function setupSearch()
    {

        if (!$this->searchFor)
        {
            return $this;
        }


        $this->collection = $this->collection->filter(function($item, $key) {
            foreach ($this->columns as $column)
            {
                if (!$column->isSearchable())
                {
                    continue;
                }

                if ($column->getType() === Column::TYPE_INT && is_numeric($this->searchFor) && (int)$item[$column->getName()] === (int)$this->searchFor)
                {
                    return true;
                }
                elseif ($column->getType() !== Column::TYPE_INT && stripos($item[$column->getName()], $this->searchFor) !== false)
                {
                    return true;
                }
            }

            return false;
        });
    }

    protected function getResults(): DataSetInterface
    {
        return new DataSet(
            $this->collection ?? [],
            $this->offset,
            $this->fullDataLength,
            $this->orderBy,
            $this->orderDir
        );
    }

    protected function setupSorting()
    {
        if (!$this->orderBy || !$this->orderDir)
        {
            return;
        }

        foreach ($this->columns as $column)
        {
            /**
             * @var $column Column
             */
            if ($this->orderBy === $column->getName())
            {
                if ($column->getType() === Column::TYPE_INT)
                {
                    $this->collection = $this->orderDir === self::SORT_ASC ? $this->collection->sortBy($column->getName(), SORT_NUMERIC) : $this->collection->sortByDesc($column->getName(), SORT_NUMERIC);
                }
                else
                {
                    $this->collection = $this->orderDir === self::SORT_ASC ? $this->collection->sortBy($column->getName(), SORT_STRING | SORT_FLAG_CASE) : $this->collection->sortByDesc($column->getName(), SORT_STRING | SORT_FLAG_CASE);
                }

                return;
            }
        }

        throw new \Exception('Invalid sort column');
    }

    public function countRawResults()
    {
        $this->fullDataLength = $this->collection->count();
    }

    protected function setupLimit()
    {
        $this->collection = $this->collection->slice($this->offset, $this->limit);
    }
}
