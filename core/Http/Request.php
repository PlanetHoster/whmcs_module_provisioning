<?php

namespace ModulesGarden\PlanetHoster\Core\Http;

use ModulesGarden\PlanetHoster\Core\Helper\BuildUrl;

/**
 * Description of Request
 */
class Request extends \Symfony\Component\HttpFoundation\Request
{
    public function __construct()
    {
        parent::__construct($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
    }

    public function getScheme()
    {
        return BuildUrl::getVisitorScheme() ?? parent::getScheme();
    }
}
