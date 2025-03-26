<?php

namespace ModulesGarden\PlanetHoster\Components\DropdownMenuItem;

class DropdownMenuItemEdit extends DropdownMenuItem
{
    public function __construct()
    {
        parent::__construct();

        $this->setIcon('edit');
    }
}
