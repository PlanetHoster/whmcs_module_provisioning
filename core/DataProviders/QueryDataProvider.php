<?php

namespace ModulesGarden\PlanetHoster\Core\DataProviders;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Query\Builder;
use ModulesGarden\PlanetHoster\Core\Contracts\DataSetInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\QueryProviderInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\QueryDataProvider\ColumnName;

class QueryDataProvider extends AbstractRecordsListDataProvider implements QueryProviderInterface
{
    use \ModulesGarden\PlanetHoster\Core\Components\FallbackTraits\QueryDataProvider;

    private $fullDataLength = 0;
    private $query = null;

    public function __construct($query = null)
    {
        $this->setQuery($query);
    }

    public function setQuery($query): QueryProviderInterface
    {
        $this->query = $query;

        return $this;
    }

    public function getData()/*: \ModulesGarden\PlanetHoster\Core\Contracts\DataSetInterface*/
    {
        $this->setupGlobalSearch();
        $this->setupFilersSearch();
        $this->getResults();
        $this->setupSorting();
        $this->countRawResults();
        $this->setupLimit();

        return $this->getResults();
    }

    protected function searchInField($column, $query, string $searchFor)
    {
        if (!$column->isSearchable())
        {
            return;
        }

        $searchWrapperPrefix = $column->getType() === Column::TYPE_INT ? '' : '%';
        $searchWrapperSuffix = $column->getType() === Column::TYPE_INT ? '' : '%';
        $searchType          = $column->getType() === Column::TYPE_INT ? '=' : 'LIKE';

        $query->orWhere(
            DB::raw('LOWER(' . ColumnName::withTableName($column->getName()) . ')'),
            $searchType,
            [$searchWrapperPrefix . strtolower($searchFor) . $searchWrapperSuffix]
        );
    }

    protected function setupFilersSearch()
    {
        foreach ($this->filterFields as $field => $searchFor)
        {
            if (array_key_exists($field, $this->columns))
            {
                $this->searchInField($this->columns[$field], $this->query, $searchFor);
            }
        }
    }

    protected function setupGlobalSearch()
    {
        if (!$this->searchFor)
        {
            return $this;
        }

        $this->query->where(function($query) {
            /**
             * @var $column Column
             */
            foreach ($this->columns as $column)
            {
                $this->searchInField($column, $query, $this->searchFor);
            }
        });

        return $this;
    }

    protected function getResults(): DataSetInterface
    {
        return new DataSet(
            $this->query->get(),
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
            if (ColumnName::onlyName($this->orderBy) === ColumnName::onlyName($column->getName()))
            {
                $this->query->orderBy(ColumnName::withTableName($column->getName()), $this->orderDir);

                return;
            }
        }

        throw new \Exception('Invalid sort column ' . $this->orderBy);
    }

    public function countRawResults()
    {
        //
        $this->fullDataLength = $this->query instanceof Builder ? $this->query->getCountForPagination() : $this->query->getQuery()->getCountForPagination();
    }

    protected function setupLimit()
    {
        $this->query->offset($this->offset);
        $this->query->limit($this->limit);
    }
}
