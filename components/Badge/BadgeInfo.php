<?php

namespace ModulesGarden\PlanetHoster\Components\Badge;

use ModulesGarden\PlanetHoster\Core\Components\Enums\Color;

/**
 * Class Form
 */
class BadgeInfo extends Badge
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(Color::INFO);
    }
}
