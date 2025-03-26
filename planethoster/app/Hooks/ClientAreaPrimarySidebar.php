<?php
use ModulesGarden\PlanetHoster\Packages\Product\Support\Facades\Sidebar;
$hookManager->register(
    function($sidebarWhmcs) {
        if (!class_exists(Sidebar::class)) {
            return;
        }

        $sidebarWhmcs->removeChild('Service Details Overview');

        $sidebars = Sidebar::getAll();
        foreach ($sidebars as $sidebar)
        {
            $newPanel = [
                'label' => $sidebar->getName(),
                'order' => 1
            ];
            $childPanel = $sidebarWhmcs->addChild($sidebar->getName(), $newPanel);
            foreach ($sidebar->getItems() as $sidebarItem)
            {
                $current = false;
                if(isset($_REQUEST['mg-action']) && !empty($_REQUEST['mg-action'])) {
                    $checkAction = 'mg-action='.$_REQUEST['mg-action'];
                    if(strpos($sidebarItem->getUrl(), $checkAction) !== false) {
                        $current = true;
                    }
                }
                elseif(strpos($sidebarItem->getUrl(), 'mg-action=index') !== false) {
                    $current = true;
                }

                $newItem = [
                    'label'   => $sidebarItem->getName(),
                    'uri'     => $sidebarItem->getUrl(),
                    'order'   => $sidebarItem->getOrder(),
                    "current" => $current
                ];
                $childPanel->addChild($sidebarItem->getName(), $newItem);
            }
        }
    },
    100
);
