<?php

namespace ModulesGarden\PlanetHoster\Core\UI;

use ModulesGarden\PlanetHoster\Components\AppNavBar\Breadcrumb;
use ModulesGarden\PlanetHoster\Components\OverlayComponents\OverlayComponents;
use ModulesGarden\PlanetHoster\Core\Helper\BuildUrl;
use ModulesGarden\PlanetHoster\Core\Helper\RandomStringGenerator;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\UI\View\AlertsBuilder;
use ModulesGarden\PlanetHoster\Core\UI\View\BreadcrumbsBuilder;
use ModulesGarden\PlanetHoster\Core\UI\View\NavBarBuilder;
use function ModulesGarden\PlanetHoster\Core\Helper\isAdmin;

/**
 *
 */
class View extends AbstractPartialView
{
    public function __construct()
    {
        $this->initDefaultComponents();
    }

    protected function initDefaultComponents()
    {
        $this->addElement(OverlayComponents::class);
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->buildRootElements($this->elements);
    }
}
