<?php

namespace ModulesGarden\PlanetHoster\Components\IconButton;

/**
 * Class IconButton
 */
class IconButtonDelete extends IconButtonDanger
{
    public function __construct()
    {
        parent::__construct();
        $this->setIcon('delete');
    }
}
