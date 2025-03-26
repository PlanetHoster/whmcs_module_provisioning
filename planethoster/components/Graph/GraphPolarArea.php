<?php

namespace ModulesGarden\PlanetHoster\Components\Graph;

/**
 * Description of EmptyGraph
 */
class GraphPolarArea extends Graph
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('polarArea');
    }
}
