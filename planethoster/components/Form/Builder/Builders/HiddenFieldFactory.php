<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Builder\Builders;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class HiddenFieldFactory extends AbstractFormFieldFactory
{
    public function create(FormFieldInterface $formField)//: FormFieldInterface
    {
        return $formField;
    }
}
