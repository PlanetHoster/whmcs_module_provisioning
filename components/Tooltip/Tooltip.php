<?php

namespace ModulesGarden\PlanetHoster\Components\Tooltip;

use ModulesGarden\PlanetHoster\Components\Icon\Icon;

/**
 * Class Form
 */
class Tooltip extends Icon
{
    public const COMPONENT = 'Tooltip';

    public function __construct()
    {
        parent::__construct();

        $this->setIcon('help-outline');
    }
}
