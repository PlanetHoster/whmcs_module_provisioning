<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\Action;

class AdminSingleSignOn extends Action
{
    public function execute($params = null)
    {
        try {
            if (empty($params['customfields']['account_id'])) {
                return [
                    'success' => false,
                    'error' => 'Custom Field /Account ID/ is not empty'
                ];
            }

            $api = new PlanetHosterAPI(
                $params['serverhostname'],
                $params['serverusername'],
                $params['serverpassword'],
                $params['serverhttpprefix']
            );

            $result = $api->loginPanel($params['customfields']['account_id']);
            if (!empty($result['data']['login_url'])) {
                return [
                    'success' => true,
                    'redirectTo' => $result['data']['login_url']
                ];
            }
            return [
                'success' => false,
                'error' => 'SSO URL not found'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
