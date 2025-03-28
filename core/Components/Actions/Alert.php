<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Actions;

use ModulesGarden\PlanetHoster\Core\Components\AbstractActionInterface;

/**
 * Use it only for debug/test
 */
class Alert extends AbstractActionInterface
{
    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'action'  => 'alert',
            'message' => $this->message
        ];
    }
}
