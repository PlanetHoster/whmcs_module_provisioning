<?php

namespace ModulesGarden\PlanetHoster\Components\IconButton;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

/**
 * Class IconButton
 */
class IconButtonEdit extends IconButtonPrimary
{
    public function __construct()
    {
        parent::__construct();
        $this->setIcon('edit');
    }
}
