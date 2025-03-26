<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Config;

use ModulesGarden\PlanetHoster\Core\Data\Container;

class Config extends Container
{
    public function __construct()
    {
        global $CONFIG;
        parent::__construct($CONFIG);
    }
}