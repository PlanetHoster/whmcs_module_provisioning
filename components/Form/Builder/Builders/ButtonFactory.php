<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Builder\Builders;

use ModulesGarden\PlanetHoster\Components\Container\ContainerFullWidth;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class ButtonFactory extends AbstractFormFieldFactory
{
    public function create(FormFieldInterface $formField)
    {
        $formGroup = new ContainerFullWidth();
        $formGroup->addElement($formField);

        return $formGroup;
    }
}
