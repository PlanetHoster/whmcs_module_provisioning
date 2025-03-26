<?php

namespace ModulesGarden\PlanetHoster\Components\Modal;

use ModulesGarden\PlanetHoster\Components\Button\ButtonCancel;
use ModulesGarden\PlanetHoster\Components\Button\ButtonSuccess;
use ModulesGarden\PlanetHoster\Core\Components\Action;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalClose;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalFormSubmit;

class ModalEdit extends ModalBase
{
    protected $actionModal = false;

 

    protected function initActionButtons()
    {
        $this->addActionButton(
            (new ButtonSuccess())
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
