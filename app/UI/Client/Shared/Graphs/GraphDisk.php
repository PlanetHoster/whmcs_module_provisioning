<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\Components\Graph\Models\DataSet;
use ModulesGarden\PlanetHoster\Components\TableSimple\Record\Record;
use ModulesGarden\PlanetHoster\Components\TableSimple\TableSimple;
use ModulesGarden\PlanetHoster\Components\Widget\Widget;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Components\Container\Container;

class GraphDisk extends Container implements ClientAreaInterface, AjaxComponentInterface
{
    public function loadHtml(): void
    {

        $widgetNew = new Widget();
        $widgetNew->setTitle($this->translate('disk_usage'));

        $tableNew = new TableSimple();

        $serviceId = Request::get('id');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];

        try {
            if (!empty($account_id)) {

                $api = new PlanetHosterAPI(
                    $serviceDetails['server']['hostname'],
                    $serviceDetails['server']['username'],
                    $serviceDetails['server']['password'],
                    $serviceDetails['server']['prefix']
                );
                $stasResponse = $api->getStatsDisk($account_id, $serviceDetails['service']['username']);


                $tableNew->addRecord(new Record([
                    $this->translate('total'),
                    '<b>'.$this->formatBytes($stasResponse['data']['total'],0).'</b>',
                ]));

                foreach ($stasResponse['data']['diskUsage'] as $name => $diskUsage)
                {
                    $tableNew->addRecord(new Record([
                        $this->translate('disk').' '. $name,
                        '<b>'.$this->formatBytes($diskUsage,0).'</b>',
                    ]));
                }

                foreach ($stasResponse['data']['dbUsage'] as $name => $dbUsage)
                {
                    $tableNew->addRecord(new Record([
                        $this->translate('database').' '. $name,
                        '<b>'.$this->formatBytes($dbUsage,0).'</b>',
                    ]));
                }

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $widgetNew->addElement($tableNew);
        $this->addElement($widgetNew);

    }

    function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        return round($bytes, $precision) .' '. $units[$pow];
    }


}
