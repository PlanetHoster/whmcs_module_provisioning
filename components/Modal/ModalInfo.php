<?php

namespace ModulesGarden\PlanetHoster\Components\Modal;

use ModulesGarden\PlanetHoster\Components\Button\ButtonCancel;
use ModulesGarden\PlanetHoster\Components\Button\ButtonClose;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalClose;

class ModalInfo extends ModalBase
{
    protected $actionModal = false;

 

    protected function initActionButtons()
    {
        $this->addActionButton(
            (new ButtonClose())
                ->setTitle($this->translate('close'))
                ->onClick(new ModalClose($this))
        );
    }
}
