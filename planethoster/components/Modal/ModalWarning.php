<?php

namespace ModulesGarden\PlanetHoster\Components\Modal;

use ModulesGarden\PlanetHoster\Components\Button\ButtonCancel;
use ModulesGarden\PlanetHoster\Components\Button\ButtonWarning;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalClose;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalFormSubmit;

class ModalWarning extends ModalAction
{
    protected $type = self::TYPE_WARNING;

    protected function initActionButtons()
    {
        $this->addActionButton(
            (new ButtonWarning())
                ->setTitle($this->translate('submit'))
                ->onClick(new ModalFormSubmit($this))
        );

        $this->addActionButton(
            (new ButtonCancel())
                ->setTitle($this->translate('cancel'))
                ->onClick(new ModalClose($this))
        );
    }
}
