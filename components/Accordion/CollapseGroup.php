<?php

namespace ModulesGarden\PlanetHoster\Components\Accordion;

class CollapseGroup extends Accordion
{
    public function __construct()
    {
        parent::__construct();

        $this->setMode(self::MODE_COLLAPSE_GROUP);
    }
}