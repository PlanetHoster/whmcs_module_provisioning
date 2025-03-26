<?php

namespace ModulesGarden\PlanetHoster\Components\ProgressBar;

use ModulesGarden\PlanetHoster\Core\Components\Enums\BackgroundColor;

class ProgressBarInfo extends ProgressBar
{
    public function __construct()
    {
        parent::__construct();
        $this->setType(BackgroundColor::INFO);
    }
}