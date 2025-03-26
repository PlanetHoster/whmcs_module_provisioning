<?php

namespace ModulesGarden\PlanetHoster\Components\FileManager\Source;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ActionInterface;

class File extends Item
{
    protected static bool $isDir = false;
    protected static string $icon = "file-text";

    public function getClickAction(AbstractComponent $component): ?ActionInterface
    {
        return null;
    }
}