<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Home\Charts;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\GraphDisk;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\GraphResource;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\GraphVisitors;
use ModulesGarden\PlanetHoster\Components\Container\Container as BaseContainer;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class Container extends BaseContainer implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->addElement(new GraphResource());
        $this->addElement(new GraphDisk());
        $this->addElement(new GraphVisitors());
    }
}