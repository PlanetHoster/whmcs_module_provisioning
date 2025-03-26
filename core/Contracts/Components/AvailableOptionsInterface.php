<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Components;

interface AvailableOptionsInterface
{
    public function setOptions(array $options): self;
}
