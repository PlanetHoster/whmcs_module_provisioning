<?php

namespace ModulesGarden\PlanetHoster\Core\UI\PageParams\Source;

interface ModuleActionInterface
{
    public function selectAppropriateParameters(array $params): array;
}