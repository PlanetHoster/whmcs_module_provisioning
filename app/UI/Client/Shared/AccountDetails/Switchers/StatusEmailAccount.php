<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Switchers;

use ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers\EmailAccountProvider;
use ModulesGarden\PlanetHoster\Components\Switcher\Switcher;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxOnActionInterface;
use ModulesGarden\PlanetHoster\Core\DataProviders\CrudProvider;

class StatusEmailAccount extends Switcher implements ClientAreaInterface, AjaxOnActionInterface
{
    protected string $provider = EmailAccountProvider::class;
    protected string $providerAction = CrudProvider::ACTION_UPDATE;
}
