<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\Action;

class TestConnection extends Action
{
    public function execute($params = null)
    {
        try {

            $api = new PlanetHosterAPI($params['serverhostname'], $params['serverusername'], $params['serverpassword'], $params['serverhttpprefix']);
            $api->accountInfo();

            return ['success' => true];

        } catch (\Exception $e) {

            return ['error' => $e->getMessage()];

        }
    }
}
