<?php

namespace ModulesGarden\PlanetHoster\Core\Http\View\MenuProviders;

use ModulesGarden\PlanetHoster\Core\FileReader\Reader;
use ModulesGarden\PlanetHoster\Core\Helper;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class MenuProviderConfig implements MenuProviderInterface
{
    public function getMenuItems(): array
    {
        $isAdmin = Helper\isAdmin();
        $file    = ($isAdmin) ? 'admin.yml' : 'client.yml';

        $menu = Reader::read(ModuleConstants::getDevConfigDir() . DIRECTORY_SEPARATOR . 'menu' . DIRECTORY_SEPARATOR . $file)->get();

        array_walk($menu, function(&$value) {
            $value = $value ?: [];
        });

        return $menu;
    }
}
