<?php

namespace ModulesGarden\PlanetHoster\Components\TreeListContainer;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;

/**
 * Class PreBlock
 */
class TreeListContainer extends AbstractComponent
{
    use AjaxTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'TreeListContainer';

    public function openOnActiveItems(bool $openOnActiveItems = true): self
    {
        $this->setSlot('openOnActiveItems', $openOnActiveItems);

        return $this;
    }
}
