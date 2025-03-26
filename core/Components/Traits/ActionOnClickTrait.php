<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\ActionInterface;

trait ActionOnClickTrait
{
    use ActionsTrait;

    public function onClick(ActionInterface $action): self
    {
        $this->addAction('onClick', $action);

        return $this;
    }
}