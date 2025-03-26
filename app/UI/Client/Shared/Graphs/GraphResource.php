<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs;

use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Options\GraphOptions;
use ModulesGarden\PlanetHoster\Components\Graph\GraphLine;
use ModulesGarden\PlanetHoster\Components\Graph\Models\DataSet;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Forms\FiltersResource;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Text\Text;

class GraphResource extends GraphLine implements ClientAreaInterface, AjaxComponentInterface
{
    public function loadHtml(): void
    {
        parent::loadHtml();
        $this->setTitle($this->translate('title'));
        $this->setOptions(new GraphOptions());
    }

    public function loadData(): void
    {
        $labels = [];
        $usages = [];

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
                
                $period = Request::get('period_resource');
                if(empty($period)) $period = '24';
                
                $type = Request::get('type_resource');
                if(empty($type)) $type = 'dRW';
                
                $typeFriendlyName = [
                    'dRW' => $this->translate('disk_read_write',[],['client.shared.graphs.forms.filters_resource']),
                    'memUsage' => $this->translate('memory_usage',[],['client.shared.graphs.forms.filters_resource']),
                    'cpuUsage' => $this->translate('cpu_usage',[],['client.shared.graphs.forms.filters_resource']),
                    'memErrors' => $this->translate('memory_errors',[],['client.shared.graphs.forms.filters_resource'])
                ];
                
                $periodFriendlyName = [
                    '24' => $this->translate('last_24_hours',[],['client.shared.graphs.forms.filters_resource']),
                    '48' => $this->translate('last_48_hours',[],['client.shared.graphs.forms.filters_resource']),
                    '7' => $this->translate('last_week',[],['client.shared.graphs.forms.filters_resource']),
                    '14' => $this->translate('last_two_weeks',[],['client.shared.graphs.forms.filters_resource'])
                ];
                
                $text = new Text();
                $text->setText($typeFriendlyName[$type]. ' - '. $periodFriendlyName[$period]);
                $this->addElement($text);

                $typeGraphs = [];
                $typeGraphs['dRW'] = ['aIO','mIO'];
                $typeGraphs['cpuUsage'] = ['aCPU','mCPU'];
                $typeGraphs['memUsage'] = ['aVMem','aPMem','mVMem','lIOPS'];
                $typeGraphs['memErrors'] = ['PMemF','VMemF'];

                // type = dRW
                // aIO = Average I/O (IO KB/s) - Disk Read Write - 255, 99, 132
                // mIO = Max I/O (IO KB/s) - Disk Read Write - 54, 162, 235

                // type = cpuUsage
                // aCPU = CPU Average (CPU%) - CPU usage - 255, 99, 132
                // mCPU = Max CPU (CPU%) - CPU usage - 54, 162, 235

                // type = memUsage
                // aVMem = Average Virtual Memory Usage (MB) - Memory usage - 255, 99, 132
                // aPMem = Average Phisical Memory Usage (MB) - Memory usage - 54, 162, 235
                // mVMem = Maximum use of virtual memory (MB) - Memory usage - 255, 159, 64
                // lIOPS = Limit (MB) - Memory usage - 255, 205, 86

                // type = memErrors
                // PMemF = Insufficeient phisical errors - Memory errors - 255, 99, 132
                // VMemF = Insufficeient virtual errors - Memory errors - 54, 162, 235

                $stasResponse = $api->getStatsResource($account_id, $serviceDetails['service']['username'], $period);

                foreach ($stasResponse['data'] as $stat) {
                    if(isset($stat['From']) && !empty($stat['From'])) {
                        $time = $stat['From'];
                    }
                    else
                    {
                        $time = date('m-d H:i');
                    }

                    $labels[] = $time;
                    foreach ($stat as $name => $usage) {
                        if(in_array($name, $typeGraphs[$type]) && $usage != 'From' && $usage != 'To') {
                            if(($name == 'aPMem' || $name == 'mVMem' || $name == 'aVMem') && $usage != '0')
                            {
                                $base = log($usage, 1024);
                                $usage = round(pow(1024, $base - floor($base)), 2);
                            }
                            $usages[$name][] = $usage;
                        }
                    }
                }


            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $this->setLabels($labels);

        foreach ($usages as $name => $usage)
        {
            $colorChart = $this->generate_random_rgb_color();

            switch ($name) {
                case 'aIO':
                case 'aCPU':
                case 'aVMem':
                case 'PMemF':
                    $colorChart = [
                        'rgba(255, 99, 132, 0.79)',
                        'rgba(255, 99, 132, 1)'
                    ];
                    break;
                case 'mIO':
                case 'mCPU':
                case 'aPMem':
                case 'VMemF':
                    $colorChart = [
                        'rgba(54, 162, 235, 0.79)',
                        'rgba(54, 162, 235, 1)'
                    ];
                    break;

                case 'mVMem':
                    $colorChart = [
                        'rgba(255, 159, 64, 0.79)',
                        'rgba(255, 159, 64, 1)'
                    ];
                    break;

                case 'lIOPS':
                    $colorChart = [
                        'rgba(255, 205, 86, 0.79)',
                        'rgba(255, 205, 86, 1)'
                    ];
                    break;
            }

            $dataSet = new DataSet();
            $dataSet->setTitle($this->translate($name))
                ->setData($usage)
                ->setConfigurationDataSet([
                    'backgroundColor' => $colorChart[0],
                    'borderColor' => $colorChart[1],
                ]);
            $this->addDataSet($dataSet);
        }

    }

    function generate_random_rgb_color() {
        $first = rand(0, 255);
        $second = rand(0, 255);
        $third = rand(0, 255);
        return [
            'rgba('.$first.', '.$second.', '.$third.', 0.79)',
            'rgba('.$first.', '.$second.', '.$third.', 1)',
        ];
    }
    
    protected function defineEditOption(): ?AbstractForm
    {
        return new FiltersResource();
    }
}
