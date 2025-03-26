<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts;

interface QueryProviderInterface extends RecordsListProviderInterface
{
    public function setQuery($query): self;
}
