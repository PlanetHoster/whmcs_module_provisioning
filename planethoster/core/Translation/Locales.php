<?php

namespace ModulesGarden\PlanetHoster\Core\Translation;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class Locales
{
    public static function getAvailable(): array
    {
        $files   = glob(ModuleConstants::getFullPath('langs', '*.php'));
        $locales = [];
        foreach ($files as $file)
        {
            if (preg_match('/\/([a-z]*)\.php/', $file, $matches))
            {
                $locales[] = $matches[1];
            }
        }

        return $locales;
    }
}