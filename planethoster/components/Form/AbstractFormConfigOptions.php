<?php

namespace ModulesGarden\PlanetHoster\Components\Form;

use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;

abstract class AbstractFormConfigOptions extends AbstractForm
{
    public function __construct()
    {
        parent::__construct();

        $this->builder = BuilderCreator::twoColumns($this);
        $this->setContainerTag('div');
    }
}