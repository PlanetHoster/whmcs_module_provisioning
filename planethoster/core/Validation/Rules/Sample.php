<?php

namespace ModulesGarden\PlanetHoster\Core\Validation\Rules;

use ModulesGarden\PlanetHoster\Core\Contracts\Validation\ImplicitRuleInterface;

class Sample implements ImplicitRuleInterface
{
    public function passes($attribute, $value)
    {
        return false;
    }

    public function message()
    {
        return '';
    }
}