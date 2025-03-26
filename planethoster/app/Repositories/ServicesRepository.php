<?php

namespace ModulesGarden\PlanetHoster\App\Repositories;

use ModulesGarden\PlanetHoster\App\Libs\Managers\ProductCustomFields;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service;
use ModulesGarden\PlanetHoster\Packages\Product\Services\ProductConfiguration;

class ServicesRepository
{
    protected $service;

    public function __construct()
    {
        $this->service = new Service();
    }

    public function getServicesData($id)
    {
        $results = [];

        $service = $this->service->where('id', $id)->first();
        if(isset($service->id))
        {
            $server = $service->server()->first();
            if(isset($server->id))
            {
                $serverPass = \decrypt($server->password);
                $prefix = $server->secure == 'on' ? 'https' : 'http';
                $results['server'] = $server->toArray();
                $results['server']['password'] = $serverPass;
                $results['server']['prefix'] = $prefix;
            }

            $fields = new ProductCustomFields($service->packageid, $id);
            $account_id = $fields->getCustomFieldsValue('account_id');
            $productConfig = (new ProductConfiguration($service->packageid))->get();

            $results['customfields']['account_id'] = $account_id;
            $results['productconfig'] = $productConfig;

            $password = \decrypt($service->password);

            $results['service'] = $service->toArray();
            $results['service']['password'] = $password;
        }

        return $results;
    }
}