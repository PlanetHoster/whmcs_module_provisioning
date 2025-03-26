<?php

namespace ModulesGarden\PlanetHoster\Components\Alert;

use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Components\Traits\AjaxTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\OutlineTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TextTrait;

class Alert extends AbstractComponent
{
    use AjaxTrait;
    use TextTrait;
    use OutlineTrait;

    public const COMPONENT = 'Alert';


    /**
     * @param string $size
     * @return $this
     */
    public function setSize(string $size): self
    {
        $this->setSlot('size', $size);

        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setType(string $title): self
    {
        $this->setSlot('type', $title);

        return $this;
    }

    /**
     * @param bool $showDismissButton
     * @return $this
     */
    public function showDismissButton(bool $showDismissButton = true): self
    {
        $this->setSlot('dismiss_button', $showDismissButton);

        return $this;
    }
}
