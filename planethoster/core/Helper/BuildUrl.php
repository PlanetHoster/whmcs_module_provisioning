<?php

namespace ModulesGarden\PlanetHoster\Core\Helper;

use ModulesGarden\PlanetHoster\Core\ModuleConstants;

/**
 * Description of BuildUrl
 */
class BuildUrl
{
    public static function currentUrl()
    {
        $qs = html_entity_decode($_SERVER['QUERY_STRING']);

        return self::fullUrl() . ($qs ? '?' . $qs : '');
    }

    public static function getBaseUrl(): string
    {
        $scheme = self::getScheme();
        $host   = self::getHost();
        $suffix = self::getUrlSuffix();

        return "{$scheme}://{$host}{$suffix}/";
    }

    public static function fullUrl(): string
    {
        $scheme = self::getScheme();
        $host   = self::getHost();

        return "{$scheme}://{$host}{$_SERVER['PHP_SELF']}";
    }

    public static function getScheme(): string
    {
        return self::getVisitorScheme() ?? self::getBaseScheme();
    }

    public static function getHost()
    {
        $host = $GLOBALS['CONFIG']['SystemURL'] ?: $_SERVER['HTTP_HOST'];
        $url = \parse_url( $host );

        return $url['host'] ?? '';
    }

    public static function getBaseScheme(): string
    {
        return (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') ? 'http' : 'https';
    }

    public static function getVisitorScheme()
    {
        if (empty($_SERVER['HTTP_CF_VISITOR']))
        {
            return null;
        }

        $visitorParams = (array)json_decode(html_entity_decode($_SERVER['HTTP_CF_VISITOR']));
        return $visitorParams['scheme'] ?? null;
    }

    public static function getUrlSuffix(): string
    {
        $suffix = $_SERVER['PHP_SELF'] ?: '';
        $suffix = explode('/', $suffix);
        array_pop($suffix);
        return implode('/', $suffix);
    }

    public static function getAssetsURL(...$path): string
    {
        global $CONFIG;

        return $CONFIG['SystemURL'] . '/modules/' . ModuleConstants::getModuleType() . '/' . ModuleConstants::getModuleName() . '/resources/assets/' . implode('/', $path);
    }

    public static function getPackagesURL(...$path): string
    {
        global $CONFIG;

        return $CONFIG['SystemURL'] . '/modules/' . ModuleConstants::getModuleType() . '/' . ModuleConstants::getModuleName() . "/packages/" . implode('/', $path);
    }

    public static function getNewUrl($protocol = 'http', $host = 'modulesgarden.com', $params = []): string
    {
        $url = "{$protocol}://{$host}";
        if ($params)
        {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    //@todo
    public static function getUrl($controller = null, $action = null, array $params = [], $isFullUrl = true)
    {
        if (isAdmin())
        {
            $url = 'addonmodules.php?module=' . ModuleConstants::getModuleName();
        }
        else
        {
            $url = 'index.php?m=' .  ModuleConstants::getModuleName();
        }

        if ($controller)
        {
            $url .= '&mg-page=' . $controller;
            if ($action)
            {
                $url .= '&mg-action=' . $action;
            }

            if ($params)
            {
                $url .= '&' . http_build_query($params);
            }
        }

        if ($isFullUrl)
        {
            $baseUrl = self::getBaseUrl();
            $url     = $baseUrl . $url;
        }

        return $url;
    }
}
