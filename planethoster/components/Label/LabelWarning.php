<?php

namespace ModulesGarden\PlanetHoster\Components\Label;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

/**
 * Class Form
 */
class LabelWarning extends Label
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(Color::WARNING);
    }
}
