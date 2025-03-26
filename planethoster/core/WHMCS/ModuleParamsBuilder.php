<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class ModuleParamsBuilder
{
    public static function get($relId)
    {
        if (!function_exists('ModuleBuildParams'))
        {
            require_once ModuleConstants::getFullPathWhmcs('includes') . DIRECTORY_SEPARATOR . "modulefunctions.php";
        }

        return \ModuleBuildParams($relId);
    }
}