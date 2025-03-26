<?php

namespace ModulesGarden\PlanetHoster\Components\Hint;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ComponentsContainerTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TitleTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\DescriptionTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AdminAreaInterface;
use ModulesGarden\PlanetHoster\Core\Support\Arr;

class Hint extends AbstractComponent implements AdminAreaInterface
{
    use TitleTrait;
    use DescriptionTrait;
    use ComponentsContainerTrait;

    public const COMPONENT = 'Hint';

    public const TYPE_DEFAULT   = 'default';
    public const TYPE_SUCCESS   = 'success';
    public const TYPE_INFO      = 'info';
    public const TYPE_WARNING   = 'warning';
    public const TYPE_DANGER    = 'danger';

    public const ICONS = [
        self::TYPE_DEFAULT  => 'dot-circle',
        self::TYPE_SUCCESS  => 'check-circle',
        self::TYPE_INFO     => 'info',
        self::TYPE_WARNING  => 'alert-triangle',
        self::TYPE_DANGER   => 'alert-octagon'
    ];

    public function setType(string $type): self
    {
        $this->setSlot('type', $type);
        $this->setIcon(Arr::get(self::ICONS, $type, ''));

        return $this;
    }

    public function setIcon(string $icon): self
    {
        $this->setSlot('icon', $icon);

        return $this;
    }
}