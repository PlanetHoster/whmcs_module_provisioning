<?php

namespace ModulesGarden\PlanetHoster\Core\Exporters\DataModels;

use ModulesGarden\PlanetHoster\Core\Exporters\Source\DataModelInterface;

class Query extends Collection implements DataModelInterface
{
    public function __construct($query)
    {
        parent::__construct($query->get());
    }
}