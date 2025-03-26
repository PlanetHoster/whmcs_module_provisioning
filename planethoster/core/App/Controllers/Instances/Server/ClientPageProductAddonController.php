<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\HttpController;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class ClientPageProductAddonController extends HttpController implements ClientAreaInterface
{
    public function execute($params = null)
    {
        return \ModulesGarden\PlanetHoster\Core\Support\Facades\Smarty::view('clientarea', parent::run($params), ModuleConstants::getTemplateDir() . '/controllers');
    }
}