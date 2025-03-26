<?php

namespace ModulesGarden\PlanetHoster\Components\Image;

use ModulesGarden\PlanetHoster\Core\Components\Traits\UrlTrait;
use ModulesGarden\PlanetHoster\Components\Container\Container;

class Image extends Container
{
    use UrlTrait;

    public const COMPONENT = 'Image';

    public function __construct()
    {
        parent::__construct();

        $this->setTranslations([
            'no_image',
        ]);
    }
}
