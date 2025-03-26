<?php

namespace ModulesGarden\PlanetHoster\Components\TileButton;

use ModulesGarden\PlanetHoster\Components\Button\Button;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ImageTrait;

/**
 * Class IconButton
 */
class TileButton extends Button
{
    use ImageTrait;

    public const COMPONENT = 'TileButton';

    public function setActive(bool $active = true): self
    {
        $this->setSlot('active', $active);

        return $this;
    }
}
