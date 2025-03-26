<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Authentication;

use \WHMCS\Authentication\CurrentUser as CurrentUserWhmcs;

/**
 * @method static isAuthenticatedUser ():bool
 * @method static isAuthenticatedAdmin ():bool
 * @method static isMasqueradingAdmin ():bool
 * @method static admin ():bool
 * @method static user ():bool
 * @method static client ():bool
 */
class CurrentUser extends CurrentUserWhmcs
{
    public static function isCurrentLoggedAdmin(?int $adminId):bool
    {
        return $adminId == CurrentUser::admin()->id;
    }
}