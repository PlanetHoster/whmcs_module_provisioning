<?php

namespace ModulesGarden\PlanetHoster\Core\Routing;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\WHMCS\Config\Config;
use function ModulesGarden\PlanetHoster\Core\Helper\isAdmin;

class Url
{
    public static function adminarea(string $path, array $parameters = []): string
    {
        global $customadminpath;
        $dir = $customadminpath ?: 'admin';

        return self::make($dir . '/' . $path, $parameters);
    }

    public static function clientarea(string $path, array $parameters = []): string
    {
        return self::make($path, $parameters);
    }

    /**
     * Generate URL to controller@method with provided parameters
     * @param string $route
     * @param array $parameters
     * @param string $level
     * @return string
     */
    public static function route(string $route = '', array $parameters = [], string $level = ModuleConstants::LEVEL_AUTO): string
    {
        [$controller, $action] = explode('@', $route);

        if ($controller)
        {
            $parameters[ModuleConstants::CONTROLLER_PAGE_PARAMETER] = $controller;
        }

        if ($action)
        {
            $parameters[ModuleConstants::CONTROLLER_ACTION_PARAMETER] = $action;
        }

        $level = $level == ModuleConstants::LEVEL_AUTO ? (isAdmin() ? ModuleConstants::LEVEL_ADMIN : ModuleConstants::LEVEL_CLIENT) : ($level);

        if ($level == ModuleConstants::LEVEL_CLIENT)
        {
            $parameters['m'] = ModuleConstants::getModuleName();

            return self::clientarea('index.php', $parameters);
        }
        else
        {
            $parameters['module'] = ModuleConstants::getModuleName();

            return self::adminarea('addonmodules.php', $parameters);
        }
    }

    public static function make(string $path, array $parameters = []): string
    {
        $urlElements = parse_url((new Config)->get('SystemURL'));

        $host     = $urlElements['host'] ?: '';
        $hostPath = $urlElements['path'] ?: '';
        $protocol = (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') ? 'http' : 'https';

        return "{$protocol}://{$host}{$hostPath}/" . $path . ($parameters ? '?' . http_build_query($parameters) : '');
    }
}