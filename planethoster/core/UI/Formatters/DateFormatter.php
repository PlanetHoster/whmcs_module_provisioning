<?php

namespace ModulesGarden\PlanetHoster\Core\UI\Formatters;

class DateFormatter extends BaseDateFormatter
{
    protected static string $moduleFormatSetting  = "configuration.formatters.date";

    public static function makeFromWhmcsFormat():self
    {
        return new self(self::getWhmcsFormat());
    }

    public function getDefaultFormat():string
    {
        return static::getWhmcsFormat();
    }

    protected static function getWhmcsFormat():string
    {
        global $CONFIG;

        $dateFormat = $CONFIG['DateFormat'];

        return str_replace(["DD", "MM", "YYYY"], ["d", "m", "Y"], $dateFormat);
    }
}