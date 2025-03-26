<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;

/**
 * @method static emergency($message, array $data = [])
 * @method static alert($message, array $data = [])
 * @method static critical($message, array $data = [])
 * @method static error($message, array $data = [])
 * @method static warning($message, array $data = [])
 * @method static notice($message, array $data = [])
 * @method static info($message, array $data = [])
 * @method static debug($message, array $data = [])
 */
class LogActivity extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\WHMCS\LogActivity::class;
    }
}
