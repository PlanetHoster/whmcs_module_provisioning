<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Http\Admin;

use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Helper;
use ModulesGarden\PlanetHoster\Core\Http\AbstractController;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Server;
use ModulesGarden\PlanetHoster\Packages\Product\Enums\ConfigSettings;
use function ModulesGarden\PlanetHoster\Core\Helper;

class ServerConfig extends AbstractController implements AdminAreaInterface
{
    public function index()
    {
        if (!Config::get(ConfigSettings::PRODUCT_SERVER_CONFIG_FORM)) {
            return;
        }

        $serverId = Request::get('id', null);
        if (is_null($serverId)) {
            return;
        }

        $server = Server::findOrFail($serverId);
        if (ModuleConstants::getModuleName() !== $server->type) {
            return;
        }

        return Helper\viewIntegrationAddon()
            ->addElement(\ModulesGarden\PlanetHoster\Packages\Product\UI\Buttons\ServerConfiguration::class);
    }
}
