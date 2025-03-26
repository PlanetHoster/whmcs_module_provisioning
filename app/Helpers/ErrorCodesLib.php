<?php

namespace ModulesGarden\PlanetHoster\App\Helpers;

use ModulesGarden\PlanetHoster\Core\HandlerError\ErrorCodes\ErrorCodes;

/**
 * @deprecated
 */
class ErrorCodesLib extends ErrorCodes
{
    public const YOUR_APP_000001 = [
        self::MESSAGE     => 'Your error message',
        self::CODE        => 'YOUR_APP_000001',
        self::DEV_MESSAGE => 'Your error message left for other developers, the error genesis explanation...',
        self::LOG         => true, //optional, determines if the error should be logged despite of inactive debug mode
    ];
}
