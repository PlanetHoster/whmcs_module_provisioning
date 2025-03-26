<?php

namespace ModulesGarden\PlanetHoster\Components\Widget;

use ModulesGarden\PlanetHoster\Core\Components\Decorator\Decorator;

class WidgetGrey extends Widget
{
    public function __construct()
    {
        parent::__construct();

        (new Decorator($this))->background()->setGrey();
    }
}
