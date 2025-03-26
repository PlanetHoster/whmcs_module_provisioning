<?php

namespace ModulesGarden\PlanetHoster\Core\UI\Formatters;

class DateTimeFormatter extends DateFormatter
{
    protected static string $moduleFormatSetting  = "configuration.formatters.dateTime";

    protected static function getWhmcsFormat():string
    {
        return parent::getWhmcsFormat() . " " . self::DEFAULT_TIME_FORMAT;
    }
}