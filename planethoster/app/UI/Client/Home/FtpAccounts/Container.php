<?php

namespace ModulesGarden\PlanetHoster\app\UI\Client\Home\FtpAccounts;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages\Databases;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages\Details;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages\Emails;
use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages\FtpAccounts;
use ModulesGarden\PlanetHoster\Components\Container\Container as BaseContainer;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;

class Container extends BaseContainer implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $this->addElement(new FtpAccounts());
    }
}