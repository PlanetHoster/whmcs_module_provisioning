<?php

namespace ModulesGarden\PlanetHoster\Components\Graph;

/**
 * Description of EmptyGraph
 */
class GraphRadar extends Graph
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('radar');
    }
}
