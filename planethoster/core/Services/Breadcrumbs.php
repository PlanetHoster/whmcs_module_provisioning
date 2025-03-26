<?php

namespace ModulesGarden\PlanetHoster\Core\Services;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Routing\Url;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Translator;
use ModulesGarden\PlanetHoster\Core\UI\Breadcrumbs\Item;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;

class Breadcrumbs extends \ModulesGarden\PlanetHoster\Core\UI\Breadcrumbs\Breadcrumbs
{
    public function __construct()
    {
        $this->addDefault();
    }

    protected function addDefault()
    {
        $route = \ModulesGarden\PlanetHoster\Core\Support\Facades\Router::getCurrentRoute();
        if (!$route)
        {
            return;
        }

        $level = ModuleConstants::getLevel();
        $this->add(new Item(Translator::get($level . '.breadcrumbs.' . $route->getName()), Url::route($route->getName())));

        if ($route->getAction() && $route->getAction() != ModuleConstants::DEFAULT_CONTROLLER_ACTION)
        {
            $this->add(new Item(Translator::get($level . '.breadcrumbs.' . $route->getName() . '_' . $route->getAction()), Url::route($route->getName() . '@' . $route->getAction(), Request::query()->all())));
        }
    }
}
