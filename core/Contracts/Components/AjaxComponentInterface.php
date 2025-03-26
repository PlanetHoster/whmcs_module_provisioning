<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Components;

interface AjaxComponentInterface
{
    public function loadData(): void;

    public function returnAjaxData();
}
