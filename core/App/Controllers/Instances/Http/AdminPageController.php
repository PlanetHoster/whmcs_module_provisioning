<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\HttpController;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\UI\AbstractPartialView;
use ModulesGarden\PlanetHoster\Core\UI\View;
use ModulesGarden\PlanetHoster\Core\UI\Views\AddonModuleAdminArea;

class AdminPageController extends HttpController implements \ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AdminAreaInterface
{
    public function execute($params = null)
    {
        return \ModulesGarden\PlanetHoster\Core\Support\Facades\Smarty::view('adminarea', parent::run($params), ModuleConstants::getTemplateDir() . '/controllers');
    }

    protected function preResolveResponse()
    {
        if($this->controllerResult instanceof View)
        {
            $this->controllerResult = new AddonModuleAdminArea($this->controllerResult);
        }
    }
}
