<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\UI\View;

//@todo refactor me
class PageNotFound extends View implements AdminAreaInterface, ClientAreaInterface
{
    public function __construct()
    {
        parent::__construct();

        $zero = new \ModulesGarden\PlanetHoster\Components\PageNotFound\PageNotFound();
        $this->addElement($zero);
    }
}
