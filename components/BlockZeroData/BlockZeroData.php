<?php

namespace ModulesGarden\PlanetHoster\Components\BlockZeroData;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Core\Components\Traits\DescriptionTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

class BlockZeroData extends Container implements ComponentContainerInterface
{
    use TitleTrait;
    use DescriptionTrait;

    public const COMPONENT = 'BlockZeroData';
}
