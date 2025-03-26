<?php

namespace ModulesGarden\PlanetHoster\Core\Http\View;

use ModulesGarden\PlanetHoster\Core\Helper\BuildUrl;
use ModulesGarden\PlanetHoster\Core\Http\View\MenuProviders\MenuProviderConfig;
use ModulesGarden\PlanetHoster\Core\Http\View\MenuProviders\MenuProviderInterface;
use ModulesGarden\PlanetHoster\Core\Http\View\MenuProviders\MenuProviderPackages;
use ModulesGarden\PlanetHoster\Core\Support\Arr;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Menu;
use ModulesGarden\PlanetHoster\Core\UI\Menu\Item;

/**
 * Description of MainMenu
 */
class MainMenu
{
    /**
     * @var array
     */
    protected $providers = [];

    public function __construct()
    {
        $this->addMenuProvider(new MenuProviderConfig);
        $this->addMenuProvider(new MenuProviderPackages);

        $this->buildMenu();
    }

    private function addMenuProvider(MenuProviderInterface $provider)
    {
        $menuItems = $provider->getMenuItems();

        $this->providers = array_merge($this->providers, Arr::mergeRecursiveDistinct($menuItems, $this->providers));
    }

    private function buildMenu()
    {
        foreach ($this->providers as $catName => $category)
        {
            if (Arr::get($category, 'hide', false))
            {
                continue;
            }

            $item = new Item($catName);

            if (isset($category['submenu']))
            {
                foreach ($category['submenu'] as $subName => &$subPage)
                {
                    if (!Arr::get($subPage, 'hide', false) && empty($subPage['url']))
                    {
                        $subtitem = new Item($subName, !empty($subPage['externalUrl']) ? $subPage['externalUrl']
                            : BuildUrl::getUrl($catName, $subName));
                        $subtitem->setTarget($subPage['target'] ?: '');
                        $subtitem->setIcon($subPage['icon'] ?: '');
                        $item->addItem($subtitem);
                    }
                }
            }

            $item->setUrl(!empty($category['externalUrl']) ? $category['externalUrl'] : BuildUrl::getUrl($catName));
            $item->setTarget($category['target'] ?? '');
            $item->setIcon($category['icon'] ?? '');
            Menu::addItem($item);
        }
    }
}
