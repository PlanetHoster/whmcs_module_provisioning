<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Builder\Builders;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Components\Form\Builder\Builder;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroup;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\FormFieldInterface;

abstract class AbstractFormFieldFactory
{
    protected $formBuilder;
    protected $formGroup;
    protected string $description = '';
    protected string $title = '';

    /**
     * @var callable
     */
    private $translate;

    public function __construct(Builder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    abstract public function create(FormFieldInterface $formField);

    /**
     * @param FormGroup $formGroup
     * @return $this
     */
    public function withFormGroup(FormGroup $formGroup): self
    {
        $this->formGroup = $formGroup;

        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Container
     */
    protected function createContainer(): FormGroup
    {
        return clone $this->formGroup;
    }
}
