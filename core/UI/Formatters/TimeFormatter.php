<?php

namespace ModulesGarden\PlanetHoster\Core\UI\Formatters;

class TimeFormatter extends BaseDateFormatter
{
    protected static string $moduleFormatSetting  = "configuration.formatters.time";

    public function getDefaultFormat(): string
    {
        return self::DEFAULT_TIME_FORMAT;
    }
}