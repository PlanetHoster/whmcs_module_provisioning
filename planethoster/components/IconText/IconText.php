<?php

namespace ModulesGarden\PlanetHoster\Components\IconText;

use ModulesGarden\PlanetHoster\Components\Icon\Icon;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TextTrait;

/**
 * Class IconButton
 */
class IconText extends Icon
{
    use TextTrait;

    public const COMPONENT = 'IconText';

    public function setLeftTextPosition(bool $leftTextPosition = true)
    {
        $this->setSlot('leftTextPosition', $leftTextPosition);

        return $this;
    }
}
