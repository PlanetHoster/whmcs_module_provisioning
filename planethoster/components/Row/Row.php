<?php

namespace ModulesGarden\PlanetHoster\Components\Row;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\CssContainerTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;

class Row extends AbstractComponent implements ComponentContainerInterface
{
    use AjaxTrait;
    use ComponentsContainerTrait;
    use CssContainerTrait;

    public const COMPONENT = 'Row';
}
