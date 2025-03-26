<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Actions;

use ModulesGarden\PlanetHoster\Core\Components\AbstractActionInterface;
use ModulesGarden\PlanetHoster\Core\Components\DataBuilder;

class ModalClose extends AbstractActionInterface
{
    protected $modal;

    public function __construct($modal = null)
    {
        $this->modal = $modal;
    }

    public function toArray(): array
    {
        return [
            'action'    => 'modalClose',
            'elementId' => $this->modal ? $this->modal->getId() : null,
        ];
    }
}
