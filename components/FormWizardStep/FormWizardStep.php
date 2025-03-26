<?php

namespace ModulesGarden\PlanetHoster\Components\FormWizardStep;

use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;

class FormWizardStep extends Form implements ComponentContainerInterface
{
    use TitleTrait;

    public const COMPONENT = 'FormWizardStep';

    public function addElement($element): self
    {
        $this->addComponent('elements', $element);

        return $this;
    }
}