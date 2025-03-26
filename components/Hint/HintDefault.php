<?php

namespace ModulesGarden\PlanetHoster\Components\Hint;

class HintDefault extends Hint
{
    public function __construct()
    {
        $this->setType(self::TYPE_DEFAULT);
        parent::__construct();
    }
}