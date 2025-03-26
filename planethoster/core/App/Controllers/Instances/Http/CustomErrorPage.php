<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\UI\View;
use function ModulesGarden\PlanetHoster\Core\translate;

class CustomErrorPage extends View implements AdminAreaInterface, ClientAreaInterface
{
    public function __construct(string $message)
    {
        parent::__construct();

        $zeroBlock = new \ModulesGarden\PlanetHoster\Components\CustomErrorPage\CustomErrorPage();
        $zeroBlock->setTitle(translate("customErrorMessages." . $message . '.title'));
        $zeroBlock->setDescription(translate("customErrorMessages." . $message . '.description'));

        $this->addElement($zeroBlock);
    }

}