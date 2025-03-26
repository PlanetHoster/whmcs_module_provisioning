<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\ActionInterface;

trait ActionOnCloseTrait
{
    use ActionsTrait;

    public function onClose(ActionInterface $action): self
    {
        $this->addAction('onClose', $action);

        return $this;
    }
}