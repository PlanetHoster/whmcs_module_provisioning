<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\Graphs\Forms;

use ModulesGarden\PlanetHoster\Components\Dropdown\Dropdown;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Form\Builder\BuilderCreator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class FiltersVisitors extends AbstractForm implements AdminAreaInterface, AjaxComponentInterface
{
    public function loadHtml(): void
    {
        $builder = BuilderCreator::simple($this);
        $builder->createField(Dropdown::class, 'period_visitors')->setOptions([
            '' => $this->translate('select_period'),
            '1h' => $this->translate('current_hour'),
            '12h' => $this->translate('12_last_hours'),
            '24h' => $this->translate('24_last_hours'),
            '7d' => $this->translate('7_last_days'),
            '30d' => $this->translate('30_last_days')
        ])->setDefaultValueAsFirstOption();
    }
}
