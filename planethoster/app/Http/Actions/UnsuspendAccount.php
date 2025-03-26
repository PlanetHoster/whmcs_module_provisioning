<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\Action;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;

class UnsuspendAccount extends Action
{
    use TranslatorTrait;
    public function execute($params = null)
    {
        try {

            if(empty($params['customfields']['account_id']))
            {
                return 'Custom Field /Account ID/ is not empty';
            }

            $api = new PlanetHosterAPI($params['serverhostname'], $params['serverusername'], $params['serverpassword'], $params['serverhttpprefix']);
            $api->unsuspendAccount($params['customfields']['account_id'], $params['username']);

            return 'success';

        } catch (\Exception $e) {

            return sprintf($this->translate($e->getMessage(), [], ['global']),'', '');

        }
    }
}
