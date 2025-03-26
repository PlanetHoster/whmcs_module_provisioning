<?php

namespace ModulesGarden\PlanetHoster\Core\Helper\Currency\Whmcs;

use ModulesGarden\PlanetHoster\Core\Helper\Currency\Models\Format;

class WhmcsFormats
{
    public static function getByFormatId(int $formatId):Format
    {
        switch ($formatId)
        {
            case 2:
                return new Format(2, ".", ",");
            case 3:
                return new Format(2, ",", ".");
            case 4:
                return new Format(0, "", ",");
            default:
                return self::getDefaultFormat();
        }
    }

    public static function getDefaultFormat():Format
    {
        return new Format(2, ".", "");
    }
}