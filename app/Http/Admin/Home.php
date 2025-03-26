<?php

namespace ModulesGarden\PlanetHoster\App\Http\Admin;

use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Http\AbstractController;
use \ModulesGarden\PlanetHoster\App\UI\Admin\Home\Index\Container;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Breadcrumbs;
use ModulesGarden\PlanetHoster\Core\UI\Breadcrumbs\Item;
use function ModulesGarden\PlanetHoster\Core\Helper\view;

class Home extends AbstractController implements AdminAreaInterface
{
    public function index()
    {
        Breadcrumbs::add(new Item('XXXX'));

        return view()->addElement(Container::class);
    }
}
