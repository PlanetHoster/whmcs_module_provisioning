<?php

namespace ModulesGarden\PlanetHoster\App\Http\Client;

use ModulesGarden\PlanetHoster\Core\Helper;
use ModulesGarden\PlanetHoster\Core\Http\AbstractClientController;

/**
 * Description of Samples
 */
class Home extends AbstractClientController implements \ModulesGarden\PlanetHoster\Core\Contracts\Controllers\ClientAreaInterface
{
    public function index()
    {
        return Helper\view()
            ->addElement(\ModulesGarden\PlanetHoster\App\UI\Client\Home\Index\Container::class);
    }

    public function emails()
    {
        return Helper\view()
            ->addElement(\ModulesGarden\PlanetHoster\App\UI\Client\Home\Emails\Container::class);
    }

    public function databases()
    {
        return Helper\view()
            ->addElement(\ModulesGarden\PlanetHoster\App\UI\Client\Home\Databases\Container::class);
    }

    public function ftpaccounts()
    {
        return Helper\view()
            ->addElement(\ModulesGarden\PlanetHoster\App\UI\Client\Home\FtpAccounts\Container::class);
    }

    public function charts()
    {
        return Helper\view()
            ->addElement(\ModulesGarden\PlanetHoster\App\UI\Client\Home\Charts\Container::class);
    }
}
