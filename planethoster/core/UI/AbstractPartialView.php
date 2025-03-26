<?php

namespace ModulesGarden\PlanetHoster\Core\UI;

use Exception;
use ModulesGarden\PlanetHoster\Core\Components\DataBuilder;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;
use ModulesGarden\PlanetHoster\Core\DependencyInjection;
use ModulesGarden\PlanetHoster\Core\UI\Helpers\TemplateConstants;
use function ModulesGarden\PlanetHoster\Core\Helper\isAdmin;

abstract class AbstractPartialView
{
    protected array $elements = [];

    /**
     * @param $element
     * @return $this
     * @throws Exception
     * @todo - refactor me
     */
    public function addElement($element): self
    {
        if (is_string($element))
        {
            $element = DependencyInjection::create($element);
        }

        if (!$element instanceof ComponentInterface)
        {
            throw new Exception('Class ' . get_class($element) . ' must implements ' . ComponentInterface::class);
        }

        $this->elements[] = $element;

        return $this;
    }


    public function getElements()
    {
        return $this->elements;
    }

    protected function buildRootElements(array $rootElements)
    {
        return array_map(function($element) {
            return (new DataBuilder($element))
                ->withHtml()
                ->toArray();
        }, $rootElements);
    }
}