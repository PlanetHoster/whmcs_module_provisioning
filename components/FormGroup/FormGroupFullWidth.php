<?php

namespace ModulesGarden\PlanetHoster\Components\FormGroup;

use ModulesGarden\PlanetHoster\Core\Components\Decorator\Decorator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class FormGroupFullWidth extends FormGroup implements FormFieldInterface
{
    public function __construct()
    {
        parent::__construct();

        (new Decorator($this))->columns()->one();
    }
}
