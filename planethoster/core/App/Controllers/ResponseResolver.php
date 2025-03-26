<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers;

use ModulesGarden\PlanetHoster\Core\App\Controllers\ResponseResolver\Resolver;
use ModulesGarden\PlanetHoster\Core\Http\JsonResponse;
use ModulesGarden\PlanetHoster\Core\Http\RedirectResponse;
use ModulesGarden\PlanetHoster\Core\Traits\OutputBuffer;
use ModulesGarden\PlanetHoster\Core\Traits\Template;
use ModulesGarden\PlanetHoster\Core\UI\View;
use ModulesGarden\PlanetHoster\Core\UI\ViewAjax;
use ModulesGarden\PlanetHoster\Core\UI\Views\AbstractView;

class ResponseResolver
{
    use OutputBuffer;
    use Template;

    /**
     * @var null|HttpController
     */
    protected $pageController = null;
    protected $response = null;

    public function __construct($response = null)
    {
        $this->setResponse($response);
    }

    /**
     * @param null $response
     * @return $this
     */
    public function setResponse($response = null)
    {
        if ($response)
        {
            $this->response = $response;
        }

        return $this;
    }

    /**
     * @return HttpController|null
     */
    public function getPageController()
    {
        return $this->pageController;
    }

    /**
     * @param null|HttpController $pageController
     */
    public function setPageController($pageController)
    {
        $this->pageController = $pageController;

        return $this;
    }

    /**
     * resolves the response
     */
    public function resolve()
    {
        $resolver = new Resolver($this->response);
        $response = $resolver->resolve();
        if ($response)
        {
            return $response;
        }

        if ($this->response instanceof View || $this->response instanceof ViewAjax || $this->response instanceof AbstractView)
        {
            $this->response = $this->response->getResponse();
        }

        if ($this->response instanceof \Symfony\Component\HttpFoundation\JsonResponse)
        {
            $this->resolveJson();
        }
        elseif ($this->response instanceof \Symfony\Component\HttpFoundation\RedirectResponse)
        {
            $this->resolveRedirect();
        }
        elseif ($this->response instanceof \Symfony\Component\HttpFoundation\Response)
        {
            $this->cleanOutputBuffer();
            $this->response->send();
            exit;
        }
        elseif ($this->response)
        {
            return $this->response;
        }
    }


    /**
     * resolve \ModulesGarden\PlanetHoster\Core\Http\JsonResponse
     */
    public function resolveJson()
    {
        $this->cleanOutputBuffer();
        /**
         * @var JsonResponse
         */
        $this->response->send();
        exit;
    }

    public function resolveRedirect()
    {
        $this->cleanOutputBuffer();

        /**
         * @var RedirectResponse
         */
        $this->response->send();
        exit;
    }
}
