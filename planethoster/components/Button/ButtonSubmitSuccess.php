<?php

namespace ModulesGarden\PlanetHoster\Components\Button;

class ButtonSubmitSuccess extends ButtonSuccess
{
    public function __construct()
    {
        parent::__construct();

        $this->setType(self::TYPE_SUBMIT);
    }
}
