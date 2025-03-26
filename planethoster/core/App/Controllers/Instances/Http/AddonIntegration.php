<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\HttpController;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Http\Response;

class AddonIntegration extends HttpController implements AdminAreaInterface, ClientAreaInterface
{
    protected $templateDir = null;
    protected $templateName = 'addonIntegration';

    public function execute($response = null)
    {
        $this->setControllerResult($response);

        if (!$this->controllerResult)
        {
            return '';
        }

        return $this->resolveResponse();
    }

    public function resolveResponse()
    {
        if ($this->controllerResult instanceof Response)
        {
            $this->controllerResult->setForceHtml();
        }

        return $this->responseResolver->setResponse($this->controllerResult)
            ->setTemplateName($this->getTemplateName())
            ->setTemplateDir($this->getTemplateDir())
            ->setPageController($this)
            ->resolve();
    }
}
