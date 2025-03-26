<?php

namespace ModulesGarden\PlanetHoster\Components\FormInputFile;

use ModulesGarden\PlanetHoster\Core\Components\FormFields\FormField;

/**
 * Class IconButton
 */
class FormInputFile extends FormField
{
    public const COMPONENT = 'FormInputFile';

    public function setMultiple($isMultiple = true): self
    {
        $this->setSlot('multiple', $isMultiple);

        return $this;
    }

    public function setAllowedFileTypes(array $types = []): self
    {
        $this->setSlot('accept', implode(', ', $types));

        return $this;
    }
}
