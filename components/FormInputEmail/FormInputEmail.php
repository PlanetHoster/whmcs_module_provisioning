<?php

namespace ModulesGarden\PlanetHoster\Components\FormInputEmail;

use ModulesGarden\PlanetHoster\Components\FormInputText\FormInputText;

class FormInputEmail extends FormInputText
{
    public function __construct()
    {
        parent::__construct();

        $this->setType('email');
        $this->setPlaceholder('email@example.com');
    }
}
