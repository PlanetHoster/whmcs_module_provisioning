<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Builder\Builders;

use ModulesGarden\PlanetHoster\Components\FormLabel\FormLabel;
use ModulesGarden\PlanetHoster\Components\Tooltip\Tooltip;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

class DefaultFactory extends AbstractFormFieldFactory
{
    public function create(FormFieldInterface $formField)//: FormFieldInterface
    {
        $formField->appendCss('lu-form-control');

        $label = new FormLabel();
        $label->setCss('lu-form-label');
        $label->setText($this->title);

        if (!empty($this->description))
        {
            $icon = new Tooltip();
            $icon->setTitle($this->description);
            $label->addElement($icon);
        }

        $formGroup = $this->createContainer();
        $formGroup->addElement($label);
        $formGroup->addElement($formField);
        $formGroup->setFieldName($formField->getName());

        return $formGroup;
    }
}
