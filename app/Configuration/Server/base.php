<?php
// phpcs:ignoreFile

use ModulesGarden\PlanetHoster\Core\App\AppContext;

if (!defined('WHMCS'))
{
    die('This file cannot be accessed directly');
}

require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'AppContext.php';

function PlanetHoster_CreateAccount(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_SuspendAccount(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_UnsuspendAccount(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_TerminateAccount(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_ChangePassword(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_CreateTemporaryUrl(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_DeleteTemporaryUrl(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_ChangePackage(array $params)
{
    #MGLICENSE_CHECK_RETURN#

    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_TestConnection(array $params)
{
    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

//function PlanetHoster_UsageUpdate(array $params)
//{
//    return (new AppContext())->runServerModule(__FUNCTION__, $params);
//}

function PlanetHoster_ConfigOptions($params = [])
{
    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

function PlanetHoster_ServiceSingleSignOn($params)
{
    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

//function PlanetHoster_MetaData()
//{
//    return (new AppContext())->runServerModule(__FUNCTION__, []);
//}

//function PlanetHoster_AdminSingleSignOn($params)
//{
//    return (new AppContext())->runServerModule(__FUNCTION__, $params);
//}

function PlanetHoster_AdminServicesTabFields($params)
{
    return (new AppContext())->runServerModule(__FUNCTION__, $params);
}

if (defined('CLIENTAREA'))
{
    function PlanetHoster_ClientArea($params)
    {
        #MGLICENSE_CHECK_RETURN#

        return (new AppContext())->runServerModule(__FUNCTION__, $params);
    }
}
