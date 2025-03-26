<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http;

use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\HttpController;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Http\Response;
use ModulesGarden\PlanetHoster\Core\UI\ViewConfigOptions;
use function json_encode;

class ConfigOptionsIntegration extends HttpController implements AdminAreaInterface
{
    protected $templateDir = null;
    protected $templateName = 'configOptionsIntegration';

    public function execute($response = null)
    {
        try
        {
            $this->setControllerResult($response);

            if (!$this->controllerResult)
            {
                return '';
            }

            $result = $this->resolveResponse();

        }
        catch (\Throwable $ex)
        {
            //todo - do that better
            $error = new \ModulesGarden\PlanetHoster\Components\BlockError\BlockError();
            $error->setException($ex);

            $view = new ViewConfigOptions();
            $view->addElement($error);
            $this->controllerResult = $view;
            $result                 = $this->resolveResponse();
        }


        $data = [
            'content' => $result,
            'mode'    => 'advanced',
        ];

        $enc = json_encode($data);

        $this->cleanOutputBuffer();
        echo $enc;
        exit;
    }

    public function resolveResponse()
    {
        if ($this->controllerResult instanceof Response)
        {
            $this->controllerResult->setForceHtml();
        }

        return $this->responseResolver->setResponse($this->controllerResult)
            ->setPageController($this)
            ->resolve();
    }
}
