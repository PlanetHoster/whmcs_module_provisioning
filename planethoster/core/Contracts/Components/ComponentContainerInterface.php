<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Components;

interface ComponentContainerInterface
{
    public function addElement($element): self;
}
