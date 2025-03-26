<?php

namespace ModulesGarden\PlanetHoster\Core\Http\Admin;

use ModulesGarden\PlanetHoster\Core\Http\AbstractController;

class PageNotFound extends AbstractController
{
    public function index()
    {
        $pageControler = new \ModulesGarden\PlanetHoster\Core\App\Controllers\Http\PageNotFound();

        return $pageControler->execute();
    }
}
