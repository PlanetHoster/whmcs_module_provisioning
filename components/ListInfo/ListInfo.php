<?php

namespace ModulesGarden\PlanetHoster\Components\ListInfo;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\CssContainerTrait;

class ListInfo extends AbstractComponent
{
    use CssContainerTrait;

    public const COMPONENT = 'ListInfo';

    public function addItem(ListInfoItem $item): self
    {
        $this->pushToSlot('items', $item->toArray());

        return $this;
    }

    /**
     * Provide array with "title" and "value" keys
     * @param array $items
     * @return void
     */
    public function setItems(array $items): self
    {
        foreach ($items as $item)
        {
            $this->addItem($item);
        }

        return $this;
    }
}
