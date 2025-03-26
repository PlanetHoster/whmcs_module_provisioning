<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Toolbar;

use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\IconButton\IconButtonEdit;
use ModulesGarden\PlanetHoster\Components\Modal\ModalEdit;
use ModulesGarden\PlanetHoster\Core\Components\Action;

class Toolbar extends \ModulesGarden\PlanetHoster\Components\Toolbar\Toolbar
{
    protected $form;

    public function loadHtml(): void
    {
        if (!$this->form)
        {
            return;
        }

        $this->form->onSubmit(Action::reloadParent());

        $modal = new ModalEdit();
        $modal->addElement($this->form);

        $icon = new IconButtonEdit();
        $icon->onClick(Action::modalOpen($modal));

        $this->addElement($icon);
    }

    public function setForm(AbstractForm $form)
    {
        $this->form = $form;

        return $this;
    }
}
