<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Forms;

use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class ServerConfiguration extends Form implements AdminAreaInterface, AjaxComponentInterface
{
    protected string $provider = \ModulesGarden\PlanetHoster\Packages\Product\UI\Providers\ServerConfiguration::class;
}