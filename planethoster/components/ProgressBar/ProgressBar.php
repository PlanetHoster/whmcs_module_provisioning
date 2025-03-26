<?php

namespace ModulesGarden\PlanetHoster\Components\ProgressBar;

use ModulesGarden\PlanetHoster\Components\Tooltip\Tooltip;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Enums\BackgroundColor;
use ModulesGarden\PlanetHoster\Core\Components\Enums\Size;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TextTrait;

class ProgressBar extends AbstractComponent
{
    use TextTrait;

    public const COMPONENT = 'ProgressBar';

    public function __construct()
    {
        parent::__construct();

        $this->setSize(Size::MEDIUM);
        $this->setType(BackgroundColor::PRIMARY);
    }

    public function setFill(float $fill)
    {
        $this->setSlot('fill', $fill);

        return $this;
    }

    public function setSize(string $size)
    {
        $this->setSlot('size', $size);

        return $this;
    }

    public function setType(string $class)
    {
        $this->setSlot('backgroundClass', $class);

        return $this;
    }

    public function setDescription(string $description)
    {
        $tooltip = new Tooltip();
        $tooltip->setTitle($description);
        $this->setSlot('descriptionTooltip', $tooltip);

        return $this;
    }
}