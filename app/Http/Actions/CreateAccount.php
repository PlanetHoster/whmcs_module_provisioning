<?php

namespace ModulesGarden\PlanetHoster\App\Http\Actions;

use ModulesGarden\PlanetHoster\App\Libs\Managers\ProductCustomFields;
use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server\Action;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ProductConfiguration;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service;

class CreateAccount extends Action
{
    use TranslatorTrait;

    public function execute($params = null)
    {

        try {

            if(!empty($params['customfields']['account_id']))
            {
                return 'Custom Field /Account ID/ is not empty';
            }

            $api = new PlanetHosterAPI($params['serverhostname'], $params['serverusername'], $params['serverpassword'], $params['serverhttpprefix']);
            $fields = new ProductCustomFields($params['packageid'], $params['serviceid']);
            $productConfig = (new ProductConfiguration($params['packageid']))->get();

            $newAccountParams = [
                'ls' => $productConfig['ls'],
                'domain' => $params['domain'],
                'cpu' => (int)$productConfig['cpu'],
                'memory' => (int)$productConfig['memory'],
                'io' => (int)$productConfig['io'],
                'disk_space' => (int)$productConfig['disk_space'],
                'cms_name' => $productConfig['cms_name'],
            ];
            // Ajouter 'country' si non vide
            if (!empty($productConfig['country'])) {
                $newAccountParams['country'] = $productConfig['country'];
            } else {
                // Ajouter 'hostname' seulement si 'country' est vide
                $newAccountParams['hostname'] = $params['serverhostname'];
            }
            
            $account = $api->createAccount($newAccountParams);

            Service::where('id', $params['serviceid'])->update([
                'username' => $account['username'],
                'password' => \encrypt($account['password']),
                'dedicatedip' => $account['server_ip']
            ]);

            $fields->updateFieldValue('account_id', '');
            $fields->updateFieldValue('account_id', $account['id']);

            return 'success';

        } catch (\Exception $e) {

            return sprintf($this->translate($e->getMessage(), [], ['global']),'', '');

        }

    }
}
