<?php

namespace ModulesGarden\PlanetHoster\Components\FormInputGroup;

use ModulesGarden\PlanetHoster\Components\Button\Button;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\CssContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ValidatorRulesTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

/**
 * Class Form
 */
class FormInputGroup extends AbstractComponent implements FormFieldInterface
{
    use ComponentsContainerTrait
    {
        ComponentsContainerTrait::addElement as addElement_;
    }
    use CssContainerTrait;
    use ValidatorRulesTrait;

    public const COMPONENT = 'FormInputGroup';

 

    public function setName(string $name): self
    {
        $this->setSlot('name', $name);
        $this->setSlot('data-field-name', $name);

        return $this;
    }

    public function addElement($element): self
    {
        $this->appendGroupBtnClassIfButton($element);
        $this->addElement_($element);

        return $this;
    }

    protected function appendGroupBtnClassIfButton($element)
    {
        if (is_subclass_of($element, Button::class))
        {
            $element->appendCss('lu-input-group__btn');
        }
    }

    public function getName(): string
    {
        return $this->getSlot('name') ?? '';
    }
}
