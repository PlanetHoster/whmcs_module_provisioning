<?php

namespace ModulesGarden\PlanetHoster\Components\Hint;

class HintWarning extends Hint
{
    public function __construct()
    {
        $this->setType(self::TYPE_WARNING);
        parent::__construct();
    }
}