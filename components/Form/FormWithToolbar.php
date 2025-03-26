<?php

namespace ModulesGarden\PlanetHoster\Components\Form;

use ModulesGarden\PlanetHoster\Components\Toolbar\Toolbar;

class FormWithToolbar extends Form
{
    protected array $toolbarElements = [];

    public function addElementToToolbar($element): self
    {
        $this->toolbarElements[] = $element;

        return $this;
    }

    public function setToolbarElements(array $toolbarElements = []): self
    {
        $this->toolbarElements = $toolbarElements;

        return $this;
    }

    public function elementsSlotBuilder()
    {
        if (!empty($this->toolbarElements))
        {
            $toolbar = new Toolbar();

            foreach ($this->toolbarElements as $element)
            {
                $toolbar->addElement($element);
            }

            $this->addElement($toolbar);
        }

        return $this->getSlot('elements');
    }

}