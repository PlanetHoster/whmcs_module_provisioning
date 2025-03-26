<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS;

class Helper
{
    public static function isAdminArea(): bool
    {
        return defined('ADMINAREA');
    }

    public static function isClientArea(): bool
    {
        return defined('CLIENTAREA');
    }
}