<?php

namespace ModulesGarden\PlanetHoster\Components\HiddenField;

use ModulesGarden\PlanetHoster\Core\Components\FormFields\FormField;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldHiddenInterface;

class HiddenField extends FormField implements FormFieldHiddenInterface
{
    public const COMPONENT = 'HiddenField';
}
