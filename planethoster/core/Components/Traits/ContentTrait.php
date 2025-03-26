<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;


trait ContentTrait
{
    /**
     * @param string $content
     * @return ContentTrait
     */
    public function setContent(string $content): self
    {
        $this->setSlot('content', $content);

        return $this;
    }
}
