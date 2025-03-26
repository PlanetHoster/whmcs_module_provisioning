<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Actions;

use ModulesGarden\PlanetHoster\Components\Form\Form;
use ModulesGarden\PlanetHoster\Core\Components\AbstractActionInterface;
use ModulesGarden\PlanetHoster\Core\Components\Actions\Traits\WithParamsTrait;

/**
 * Use it only for debug/test
 */
class DownloadFileFromForm extends AbstractActionInterface
{
    use WithParamsTrait;

    protected Form $form;

    protected array $params = [];

    public function __construct(Form $form, array $params = [])
    {
        $this->form = $form;

        $this->params = $params;
    }

    public function toArray(): array
    {
        return [
            'action' => 'downloadFile',
            'form'   => $this->form,
            'params' => $this->params
        ];
    }
}
