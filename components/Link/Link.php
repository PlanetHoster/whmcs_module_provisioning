<?php

namespace ModulesGarden\PlanetHoster\Components\Link;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\UrlTrait;

class Link extends AbstractComponent
{
    use TitleTrait;
    use UrlTrait;
    
    public const COMPONENT = 'Link';
}
