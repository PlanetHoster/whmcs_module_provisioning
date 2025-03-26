<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Options;

use ModulesGarden\PlanetHoster\Components\Graph\Models\Options;

class GraphOptions extends Options
{
    public function __construct()
    {
        $this->updateChartScale('yAxes', [
                [
                    'ticks' => [
                        'beginAtZero' => true,
                    ],
                ],
            ]
        );

        $this->setTooltipsMode('point');
    }
}
