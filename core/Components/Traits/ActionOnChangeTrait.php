<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\ActionInterface;

trait ActionOnChangeTrait
{
    use ActionsTrait;

    public function onChange(ActionInterface $action): self
    {
        $this->addAction('onChange', $action);

        return $this;
    }
}