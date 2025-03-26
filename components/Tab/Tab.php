<?php

namespace ModulesGarden\PlanetHoster\Components\Tab;

use ModulesGarden\PlanetHoster\Components\Component\Component;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ContentTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;

/**
 * Class Tab
 */
class Tab extends AbstractComponent implements ComponentContainerInterface
{
    use ComponentsContainerTrait;
    use TitleTrait;
    use ContentTrait;

    public const COMPONENT = 'Tab';
}
