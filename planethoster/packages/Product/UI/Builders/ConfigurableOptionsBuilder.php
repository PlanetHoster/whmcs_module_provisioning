<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\UI\Builders;

use ModulesGarden\PlanetHoster\Components\Container\ContainerColumn;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Form\Builder\Builder;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroup;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroupFullWidth;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;
use ModulesGarden\PlanetHoster\Packages\Product\UI\GroupBuilders\ConfigOptionSwitcherBuilder;

class ConfigurableOptionsBuilder extends Builder
{
    public function __construct(AbstractForm $form)
    {
        parent:: __construct($form);
        $this->setDefaultFormGroup(new FormGroupFullWidth());
        $this->addDefaultContainer(new ContainerColumn());
    }

    public function createGroup(FormFieldInterface $field, bool $showTooltip = true, FormGroup $formGroup = null)
    {
        return (new ConfigOptionSwitcherBuilder($this, $this->form, $this->defaultFormGroup))->build($field, $showTooltip, $formGroup);
    }
}