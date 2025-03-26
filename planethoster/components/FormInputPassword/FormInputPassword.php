<?php

namespace ModulesGarden\PlanetHoster\Components\FormInputPassword;

use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;

/**
 * Class IconButton
 */
class FormInputPassword extends FormInputText
{
    public const COMPONENT = 'FormInputText';

    public function __construct()
    {
        parent::__construct();

        $this->setType('password');
    }
}
