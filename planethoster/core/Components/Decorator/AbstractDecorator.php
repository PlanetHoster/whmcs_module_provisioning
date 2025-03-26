<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Decorator;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

abstract class AbstractDecorator
{
    protected ComponentInterface $component;

    public function __construct(ComponentInterface $component)
    {
        $this->component = $component;
    }

    protected function appendClass(string $cssClassName): self
    {
        $this->component->appendCss($cssClassName);

        return $this;
    }
}