<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

/**
 * Trait ValueTrait
 */
trait ValueTrait
{
    /**
     * @param $value
     * @return self
     */
    public function setValue($value): self
    {
        $this->setSlot('value', $value);

        return $this;
    }
}
