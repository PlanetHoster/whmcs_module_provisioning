<?php

namespace ModulesGarden\PlanetHoster\Core\Helper\Currency\Whmcs;

use ModulesGarden\PlanetHoster\Core\Helper\Currency\Formatter;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Client;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Currency;

class WhmcsFormatsFactory
{
    public static function forCurrency(Currency $currency):Formatter
    {
        $formatter = new Formatter();

        $formatter->setPrefix($currency->prefix);
        $formatter->setSuffix($currency->suffix);
        $formatter->setFormat(WhmcsFormats::getByFormatId($currency->format));

        return $formatter;
    }

    public static function forCurrencyId(int $currencyId):Formatter
    {
        return self::forCurrency(Currency::find($currencyId));
    }

    public static function forClientId(int $clientId):Formatter
    {
        return self::forClient(Client::find($clientId));
    }

    public static function forClient(Client $client):Formatter
    {
        return self::forCurrency($client->currencyObj);
    }

    public static function forCurrentClient():Formatter
    {
        return self::forCurrency(Currency::factoryForClientArea());
    }

    public static function whmcsDefault():Formatter
    {
        return self::forCurrency(Currency::defaultCurrency()->first());
    }
}