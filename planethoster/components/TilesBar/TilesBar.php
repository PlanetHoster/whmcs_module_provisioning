<?php

namespace ModulesGarden\PlanetHoster\Components\TilesBar;

use ModulesGarden\PlanetHoster\Components\TileButton\TileButton;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;

class TilesBar extends AbstractComponent implements ComponentContainerInterface
{
    use AjaxTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'TilesBar';

    public function addTile(TileButton $tile): self
    {
        $this->addElement($tile);

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->setSlot('title', $title);

        return $this;
    }

    public function setTitleTextCentered(bool $titleTextCentered = true): self
    {
        $this->setSlot('titleTextCentered', $titleTextCentered);

        return $this;
    }
}
