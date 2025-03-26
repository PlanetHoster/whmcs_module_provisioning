<?php

namespace ModulesGarden\PlanetHoster\Components\Badge;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

/**
 * Class Form
 */
class BadgeSuccess extends Badge
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(Color::SUCCESS);
    }
}
