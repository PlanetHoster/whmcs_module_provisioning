<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Services;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Services\Sidebar as CoreSidebarService;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Hosting;
use ModulesGarden\PlanetHoster\Packages\Product\Enums\ConfigSettings;

class Sidebar extends CoreSidebarService
{
    protected function load()
    {
        if (Request::get('action', '') != 'productdetails')
        {
            return;
        }

        $service = Hosting::find(Request::get('id'));

        if ($service->product->servertype != ModuleConstants::getModuleName())
        {
            return;
        }

        if ($service->domainstatus != 'Active')
        {
            return;
        }

        $this->build(\ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get(ConfigSettings::SIDEBARS, []));
    }
}