<?php

namespace ModulesGarden\PlanetHoster\Components\FormGroup;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class FormGroup extends Container implements FormFieldInterface
{
    public const COMPONENT = 'FormGroup';

 

    public function getName(): string
    {
        return '';
        // TODO: Implement getName() method.
    }

    public function setError($error)
    {
        $this->setSlot('error', $error);
    }

    public function setFieldName($fieldName)
    {
        $this->setSlot('fieldName', $fieldName);
    }
}
