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
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Forms\FiltersVisitors;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Text\Text;

class GraphVisitors extends GraphLine implements ClientAreaInterface, AjaxComponentInterface
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

        $period = Request::get('period_visitors');
        if(empty($period)) $period = '1h';
        
        $periodFriendlyName = [
            '1h' => $this->translate('current_hour',[],['client.shared.graphs.forms.filters_visitors']),
            '12h' => $this->translate('12_last_hours',[],['client.shared.graphs.forms.filters_visitors']),
            '24h' => $this->translate('24_last_hours',[],['client.shared.graphs.forms.filters_visitors']),
            '7d' => $this->translate('7_last_days',[],['client.shared.graphs.forms.filters_visitors']),
            '30d' => $this->translate('30_last_days',[],['client.shared.graphs.forms.filters_visitors'])
        ];
                
        $text = new Text();
        $text->setText($periodFriendlyName[$period]);
        $this->addElement($text);
        
        try {
            if (!empty($account_id)) {

                $api = new PlanetHosterAPI(
                    $serviceDetails['server']['hostname'],
                    $serviceDetails['server']['username'],
                    $serviceDetails['server']['password'],
                    $serviceDetails['server']['prefix']
                );
                $stasResponse = $api->getStatsVisitors($account_id, $serviceDetails['service']['domain'], $period);

                foreach ($stasResponse['data']['labels'] as $label) {
                    $labels[] = date('d/m H:i', $label/1000);
                }
                foreach ($stasResponse['data']['success'] as $usage) {
                    $usages['success'][] = $usage;
                }
                foreach ($stasResponse['data']['redirects'] as $usage) {
                    $usages['redirects'][] = $usage;
                }
                foreach ($stasResponse['data']['clientErrors'] as $usage) {
                    $usages['clientErrors'][] = $usage;
                }
                foreach ($stasResponse['data']['serverErrors'] as $usage) {
                    $usages['serverErrors'][] = $usage;
                }

            }
        } catch (\Exception $e) {

            \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

        }

        $this->setLabels($labels);

        foreach ($usages as $name => $usage)
        {
            switch ($name) {
                case 'success':
                    $colorChart = [
                        "rgba(132, 183, 73, 0.79)",
                        "rgba(132, 183, 73, 1)",
                    ];
                    break;
                case 'redirects':
                    $colorChart = [
                        "rgba(246, 189, 34, 0.79)",
                        "rgba(246, 189, 34, 1)",
                    ];
                    break;
                case 'clientErrors':
                    $colorChart = [
                        "rgba(8, 130, 195, 0.79)",
                        "rgba(8, 130, 195, 1)",
                    ];
                    break;
                case 'serverErrors':
                    $colorChart = [
                        "rgba(241, 92, 93, 0.79)",
                        "rgba(241, 92, 93, 1)",
                    ];
                    break;
                default:
                    $colorChart = $this->generate_random_rgb_color();
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
        return new FiltersVisitors();
    }
}
