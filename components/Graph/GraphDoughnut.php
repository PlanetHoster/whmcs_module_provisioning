<?php

namespace ModulesGarden\PlanetHoster\Components\Graph;

class GraphDoughnut extends Graph
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('doughnut');
    }
}
