<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\Action;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ProductConfiguration;

class ChangePackage extends Action
{
    public function execute($params = null)
    {
        try {

            if(empty($params['customfields']['account_id']))
            {
                return 'Custom Field /Account ID/ is not empty';
            }

            $api = new PlanetHosterAPI($params['serverhostname'], $params['serverusername'], $params['serverpassword'], $params['serverhttpprefix']);
            $productConfig = (new ProductConfiguration($params['packageid']))->get();

            $updateParams = [
                'id' => $params['customfields']['account_id'],
                'username' => $params['username'],
                'cpu' => $productConfig['cpu'],
                'memory' => $productConfig['memory'],
                'io' => $productConfig['io']
            ];
            $api->updateAccount($updateParams);

            return 'success';

        } catch (\Exception $e) {

            return 'success';

        }
    }
}
