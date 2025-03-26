<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Data;

use function ModulesGarden\PlanetHoster\Core\validator;

class Validate
{
    public function run(array $elements)
    {
        $validatableElementsBag = new ValidatableElementsBag($elements);

        validator()->validate(
            \ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get('formData') ?? [],
            $validatableElementsBag->getValidators(),
            $validatableElementsBag->getCustomAttributes(),
            $validatableElementsBag->getCustomValues()
        );
    }
}
