<?php

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon\Config;
use ModulesGarden\PlanetHoster\Core\DependencyInjection\PackageServices;
use ModulesGarden\PlanetHoster\Core\Events\Dispatcher;
use ModulesGarden\PlanetHoster\Core\Lang\Lang;
use ModulesGarden\PlanetHoster\Core\Services\Breadcrumbs;
use ModulesGarden\PlanetHoster\Core\Services\Messages;
use ModulesGarden\PlanetHoster\Core\Services\Route;
use ModulesGarden\PlanetHoster\Core\Services\Translator;
use ModulesGarden\PlanetHoster\Core\Services\Validator;
use ModulesGarden\PlanetHoster\Core\Session\Session;

return [
    Dispatcher::class,

    //New
    Translator::class,
    Validator::class,
    PackageServices::class,
    \ModulesGarden\PlanetHoster\Core\Services\Params::class,
    Session::class,
    Breadcrumbs::class,
    Messages::class,
    \ModulesGarden\PlanetHoster\Core\Services\Router::class,
    \ModulesGarden\PlanetHoster\Core\Services\Smarty::class,
    \ModulesGarden\PlanetHoster\Core\Services\Request::class,
    \ModulesGarden\PlanetHoster\Core\Services\Config::class,
    \ModulesGarden\PlanetHoster\Core\Services\Binder::class,
    \ModulesGarden\PlanetHoster\Core\Services\Menu::class,
    Lang::class,
    \ModulesGarden\PlanetHoster\Core\Services\Store::class
];
