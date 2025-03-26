<?php

namespace ModulesGarden\PlanetHoster\Core\Components\FormFields;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class AbstractDecorator implements FormFieldInterface
{
    protected FormField $field;

    public function __construct(FormField $field)
    {
        $this->field = $field;
    }

    public function getName(): string
    {
        return $this->field->getName();
    }
}