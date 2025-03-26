<?php

namespace ModulesGarden\PlanetHoster\Components\Alert;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

class AlertSuccess extends Alert
{
    public function __construct()
    {
        parent::__construct();

        $this->setType(Color::SUCCESS);
    }
}
