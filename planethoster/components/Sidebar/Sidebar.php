<?php

namespace ModulesGarden\PlanetHoster\Components\Sidebar;

use ModulesGarden\PlanetHoster\Components\SidebarItem\SidebarItem;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Router;

class Sidebar extends AbstractComponent
{
    use TitleTrait;

    public const COMPONENT = 'Sidebar';

    protected array $items = [];

    /**
     * @return $this
     */
    public function addItem(SidebarItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    protected function itemsSlotBuilder(): array
    {
        $this->findAndActiveItem();
        return $this->items;
    }

    protected function findAndActiveItem()
    {
        foreach ($this->items as $item)
        {
            $parts = parse_url($item->getUrl());
            $queryParams = [];
            parse_str($parts['query'], $queryParams);

            if (empty($queryParams['mg-page']) || empty($queryParams['mg-action']))
            {
                continue;
            }

            if (Router::getCurrentRoute()->is($queryParams['mg-page'], $queryParams['mg-action']))
            {
                $item->setActive(true);
                return;
            }
        }

        reset($this->items);
        $firstItem = current($this->items);
        $firstItem->setActive(true);
    }
}