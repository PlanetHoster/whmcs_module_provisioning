<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts;

interface ArrayProviderInterface extends RecordsListProviderInterface
{
    public function setData(array $data): self;
}
