<?php

namespace ModulesGarden\PlanetHoster\Core\Services;

use ModulesGarden\PlanetHoster\Core\UI\Sidebar\Sidebar as SidebarContainer;
use ModulesGarden\PlanetHoster\Core\UI\Sidebar\Item as SidebarItem;

class Sidebar
{
    protected array $sidebars = [];

    public function __construct()
    {
        $this->load();
    }

    public function getAll(): array
    {
        return $this->sidebars;
    }

    public function getByName(string $name)
    {
        return $this->sidebars[$name];
    }

    public function addSidebar(SidebarContainer $sidebar)
    {
        $this->sidebars[$sidebar->getName()] = $sidebar;

        return $this;
    }

    protected function load()
    {
        $this->build(\ModulesGarden\PlanetHoster\Core\Support\Facades\Config::get('sidebars', []));
    }

    protected function build(array $data = [])
    {
        foreach ($data as $sidebarName => $sidebarContent)
        {
            $sidebar = new SidebarContainer($sidebarName);

            foreach ($sidebarContent as $itemName => $item)
            {
                $itemUrl = is_callable($item['uri']) ? call_user_func($item['uri']) : $item['uri'];
                $sidebar->addItem(new SidebarItem($itemName, $itemUrl, $item['order']));
            }

            $this->addSidebar($sidebar);
        }
    }
}