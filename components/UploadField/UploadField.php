<?php

namespace ModulesGarden\PlanetHoster\Components\UploadField;

use ModulesGarden\PlanetHoster\Components\FormInputFile\FormInputFile;
use ModulesGarden\PlanetHoster\Components\FormInputGroup\FormInputGroup;
use ModulesGarden\PlanetHoster\Components\FormInputLabel\FormInputLabel;

class UploadField extends FormInputGroup
{
    const DEFAULT_BROWSE_BTN_TITLE = "Browse";

    protected FormInputFile $uploadField;
    protected FormInputLabel $uploadFieldLabel;

    public function __construct()
    {
        parent::__construct();
        $this->createFields();
        $this->appendCss('lu-upload-field');
    }

    public function setName(string $name): self
    {
        $this->uploadField->setName($name);

        return $this;
    }

    public function setLabelIcon(string $icon): self
    {
        $this->uploadFieldLabel->setIcon($icon);

        return $this;
    }

    public function setMultiple(bool $multiple = true): self
    {
        $this->uploadField->setMultiple($multiple);

        return $this;
    }

    public function setLabelTitle(string $title): self
    {
        $this->uploadFieldLabel->setText($title);

        return $this;
    }

    public function setPlaceholder(string $placeholder): self
    {
        $this->uploadField->setPlaceholder($placeholder);

        return $this;
    }

    public function setAllowedFileTypes(array $types): self
    {
        $this->uploadField->setAllowedFileTypes($types);

        return $this;
    }

    public function getName(): string
    {
        return $this->uploadField->getName();
    }

    protected function createFields()
    {
        $this->uploadField = (new FormInputFile())
            ->appendCss('lu-upload-field-input');

        $this->uploadFieldLabel = (new FormInputLabel())
            ->setText(self::DEFAULT_BROWSE_BTN_TITLE)
            ->appendCss('lu-input-group__btn')
            ->setFor($this->uploadField->getId());

        $this->addElement($this->uploadField);
        $this->addElement($this->uploadFieldLabel);
    }
}
