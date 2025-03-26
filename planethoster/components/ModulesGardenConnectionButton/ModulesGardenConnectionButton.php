<?php

namespace ModulesGarden\PlanetHoster\Components\ModulesGardenConnectionButton;

use ModulesGarden\PlanetHoster\Core\Components\Traits\TextTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\UrlTrait;
use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ActionOnClickTrait;

class ModulesGardenConnectionButton extends Container
{
    use ActionOnClickTrait;
    use UrlTrait;
    use TextTrait;

    public const COMPONENT = 'ModulesGardenConnectionButton';
}
