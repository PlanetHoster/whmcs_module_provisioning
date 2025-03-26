<?php

namespace ModulesGarden\PlanetHoster\Core\UI\View;

use ModulesGarden\PlanetHoster\Components\AppBreadcrumb\AppBreadcrumb;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Breadcrumbs;

class BreadcrumbsBuilder
{
    public function create(): AppBreadcrumb
    {
        $breadcrumb = new AppBreadcrumb();
        $breadcrumb->setItems(Breadcrumbs::get());

        return $breadcrumb;
    }
}