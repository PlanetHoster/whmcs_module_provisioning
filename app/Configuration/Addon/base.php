<?php
// phpcs:ignoreFile

use ModulesGarden\PlanetHoster\Core\App\AppContext;

if (!defined('WHMCS'))
{
    die('This file cannot be accessed directly');
}

require_once dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'AppContext.php';

function PlanetHoster_config()
{
    return (new AppContext())->runAddonModule(__FUNCTION__, []);
}

function PlanetHoster_activate()
{
    return (new AppContext())->runAddonModule(__FUNCTION__, []);
}

function PlanetHoster_deactivate()
{
    return (new AppContext())->runAddonModule(__FUNCTION__, []);
}

function PlanetHoster_upgrade($params)
{
    return (new AppContext())->runAddonModule(__FUNCTION__, $params);
}

function PlanetHoster_output($params)
{
    #MGLICENSE_CHECK_ECHO_AND_RETURN_MESSAGE#

    $html = (new AppContext())->runAddonModule(__FUNCTION__, $params);

    if (is_array($html))
    {
        print_r($html);
    }
    elseif ($html)
    {
        echo $html;
    }
}

if (defined('CLIENTAREA'))
{
    function PlanetHoster_clientarea($params)
    {
        #MGLICENSE_CHECK_ECHO_AND_RETURN_MESSAGE#

        return (new AppContext())->runAddonModule(__FUNCTION__, []);
    }
}
