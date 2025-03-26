<?php

namespace ModulesGarden\PlanetHoster\Components\Text;

use ModulesGarden\PlanetHoster\Core\Components\Decorator\Decorator;

class TextBold extends Text
{
    public function __construct()
    {
        parent::__construct();

        (new Decorator($this))->font()->setBoldWeight();
    }
}