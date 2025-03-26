<?php

namespace ModulesGarden\PlanetHoster\Components\RadioButton;

use ModulesGarden\PlanetHoster\Core\Components\FormFields\FormField;
use ModulesGarden\PlanetHoster\Core\Components\Traits\OptionsTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AvailableOptionsInterface;

class RadioButton extends FormField implements AvailableOptionsInterface
{
    use OptionsTrait;

    public const COMPONENT = 'RadioButton';
}
