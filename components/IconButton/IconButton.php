<?php

namespace ModulesGarden\PlanetHoster\Components\IconButton;

use ModulesGarden\PlanetHoster\Components\Button\Button;
use ModulesGarden\PlanetHoster\Core\Components\Enums\Size;

/**
 * Class IconButton
 */
class IconButton extends Button
{
    public const COMPONENT              = 'IconButton';
    public const LABEL_POSITION_RIGHT   = 'right';
    public const LABEL_POSITION_LEFT    = 'left';

    public function __construct()
    {
        parent::__construct();
        $this->setType('default');
        $this->setSize(Size::SMALL);
    }

    public function displayWithTitle(?string $title = null, string $textPosition = self::LABEL_POSITION_RIGHT): self
    {
        $this->setSlot('label', empty($title) ? $this->translate('label') : $title);
        $this->setSlot('labelPosition', $textPosition);

        return $this;
    }
}
