<?php

namespace ModulesGarden\PlanetHoster\Components\Tagger;

use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;

class Tagger extends Dropdown
{
    public function __construct()
    {
        parent::__construct();

        $this->setMultiple(true);
        $this->setAllowToCreate(true);
    }
}
