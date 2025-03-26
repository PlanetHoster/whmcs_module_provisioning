<?php

namespace ModulesGarden\PlanetHoster\Components\MediaLibrary;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxOnLoadInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\ResponseInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\ObjectDataProvider;
use ModulesGarden\PlanetHoster\Core\Components\Response\Response;
use ModulesGarden\PlanetHoster\Core\Support\Text;

class MediaLibrary extends AbstractComponent implements AjaxOnLoadInterface, ComponentContainerInterface
{
    use AjaxTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'MediaLibrary';

    public const MODE_MANAGE    = 'mode_manage';
    public const MODE_SELECT    = 'mode_select';
    public const MODE_PRESENT   = 'mode_present';

    protected string $mode;

    private array $mediaItems = [];
    private ObjectDataProvider $dataProvider;

    public function __construct()
    {
        parent::__construct();

        $this->setMode(self::MODE_MANAGE);
    }

    public function returnAjaxData(): ResponseInterface
    {
        $this->buildHtml();
        $this->loadData();
        $this->getDataFromDataProvider();

        $this->prepareElements();

        return new Response($this->toArray());
    }

    public function loadHtml(): void
    {
    }

    //@todo refactor

    public function loadData(): void
    {
    }

    private function getDataFromDataProvider(): void
    {
        $this->mediaItems = $this->dataProvider->getData();
    }

    protected function prepareElements()
    {
        foreach ($this->mediaItems as $item)
        {
            $item->setMode($this->mode);
            $this->addElement($item);
        }
    }

    public function setDataProvider(ObjectDataProvider $provider)
    {
        $this->dataProvider = $provider;
    }

    public function addToToolbar(ComponentInterface $component): self
    {
        $this->addComponent('toolbar', $component);
        return $this;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;
        $this->setSlot('mode', $mode);

        return $this;
    }
}
