<?php

namespace ModulesGarden\PlanetHoster\Components\Form;

use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;

abstract class AbstractFormOneColumn extends AbstractForm
{
    public function __construct()
    {
        parent::__construct();

        $this->builder = BuilderCreator::oneColumn($this);
    }
}