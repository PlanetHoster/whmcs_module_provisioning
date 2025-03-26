<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Forms;

use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class FiltersResource extends AbstractForm implements AdminAreaInterface, AjaxComponentInterface
{
    public function loadHtml(): void
    {
        $builder = BuilderCreator::simple($this);
        $builder->createField(Dropdown::class, 'type_resource')->setOptions([
            '' => $this->translate('select_type'),
            'dRW' => $this->translate('disk_read_write'),
            'memUsage' => $this->translate('memory_usage'),
            'cpuUsage' => $this->translate('cpu_usage'),
            'memErrors' => $this->translate('memory_errors')
        ])->setDefaultValueAsFirstOption();
        
        $builder->createField(Dropdown::class, 'period_resource')->setOptions([
            '' => $this->translate('select_period'),
            '24' => $this->translate('last_24_hours'),
            '48' => $this->translate('last_48_hours'),
            '7' => $this->translate('last_week'),
            '14' => $this->translate('last_two_weeks')
        ])->setDefaultValueAsFirstOption();
    }
}
