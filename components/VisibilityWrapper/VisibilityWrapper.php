<?php

namespace ModulesGarden\PlanetHoster\Components\VisibilityWrapper;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;

class VisibilityWrapper extends AbstractComponent
{
    public const COMPONENT = 'VisibilityWrapper';

    public function __construct($element)
    {
        $this->setSlot('element', $element);
        parent::__construct();
    }

    /**
     * @param string $slotName
     * @param string $value
     * @return self
     */
    public function disableWhen(string $slotName, string $value): self
    {
        $this->setSlot('autoDisableFieldName', $slotName);
        $this->setSlot('autoDisableFieldValue', $value);

        return $this;
    }

    /**
     * @param string $slotName
     * @param string $value
     * @return self
     */
    public function hideWhen(string $slotName, string $value): self
    {
        $this->setSlot('autoHideFieldName', $slotName);
        $this->setSlot('autoHideFieldValue', $value);

        return $this;
    }
}