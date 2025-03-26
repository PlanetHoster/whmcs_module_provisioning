<?php

namespace ModulesGarden\PlanetHoster\Components\IconButton;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

/**
 * Class IconButton
 */
class IconButtonDanger extends IconButton
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(Color::DANGER);
    }
}
