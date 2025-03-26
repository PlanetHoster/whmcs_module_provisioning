<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

/**
 * Trait ElementsTrait
 */
trait SizeTrait
{
    public function setsize(string $size): self
    {
        $this->setSlot('size', $size);

        return $this;
    }
}
