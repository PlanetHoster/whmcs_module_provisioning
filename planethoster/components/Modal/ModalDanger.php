<?php

namespace ModulesGarden\PlanetHoster\Components\Modal;

use ModulesGarden\PlanetHoster\Components\Button\ButtonCancel;
use ModulesGarden\PlanetHoster\Components\Button\ButtonDanger;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalClose;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalFormSubmit;

class ModalDanger extends ModalAction
{
    protected $type = self::TYPE_DANGER;

    protected function initActionButtons()
    {
        $this->addActionButton(
            (new ButtonDanger())
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
