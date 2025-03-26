<?php

namespace ModulesGarden\PlanetHoster\Components\Graph;

use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\Graph\Models\Data;
use ModulesGarden\PlanetHoster\Components\Graph\Models\DataSet;
use ModulesGarden\PlanetHoster\Components\Graph\Models\Options;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxOnLoadInterface;

/**
 * Description of EmptyGraph
 */
class Graph extends AbstractComponent implements AjaxOnLoadInterface
{
    use AjaxTrait;
    use TitleTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'Graph';
    protected $data = null;
    protected $options = null;

    public function __construct()
    {
        parent::__construct();

        $this->data    = new Data();
        $this->options = new Options();
    }

    /**
     * @param DataSet $dataSet
     * @return $this
     */
    public function addDataSet(DataSet $dataSet)
    {
        $this->data->addDataSet($dataSet);

        return $this;
    }

    protected function dataSlotBuilderJson()
    {
        return $this->data->toArray();
    }

    public function loadHtml(): void
    {
        $this->buildToolbar();
    }

    /**
     * Override to create custom toolbar
     * @return void
     */
    protected function buildToolbar()
    {
        if ($form = $this->defineEditOption())
        {
            $toolbar = new Toolbar\Toolbar();
            $toolbar->setForm($form);

            $this->addElement($toolbar);
        }
    }

    /**
     * Override to enable edit option for the graphs
     * @return AbstractForm|null
     */
    protected function defineEditOption(): ?AbstractForm
    {
        return null;
    }

    protected function optionsSlotBuilderJson()
    {
        return $this->options->toArray();
    }

    /**
     * @param $labels
     * @return $this
     */
    public function setLabels(array $labels = [])
    {
        $this->data->setLabels($labels);

        return $this;
    }

    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type)
    {
        $this->setSlot('type', $type);

        return $this;
    }
}
