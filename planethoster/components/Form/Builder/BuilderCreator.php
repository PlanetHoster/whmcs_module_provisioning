<?php

namespace ModulesGarden\PlanetHoster\Components\Form\Builder;

use ModulesGarden\PlanetHoster\Components\Container\ContainerColumn;
use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroup;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroupFullWidth;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroupHalfWidth;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroupQuarterWidth;
use ModulesGarden\PlanetHoster\Components\FormGroup\FormGroupThirdWidth;
use ModulesGarden\PlanetHoster\Components\RowFluid\RowFluid;
use ModulesGarden\PlanetHoster\Core\Components\Decorator\Decorator;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentContainerInterface;

abstract class BuilderCreator
{
    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function oneColumn(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupFullWidth())
            ->addDefaultContainer(new RowFluid());
    }

    public static function oneColumnHalfPage(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupFullWidth())
            ->addDefaultContainer(new ContainerColumn());
    }

    /**
     * @param AbstractForm $form
     * @param ComponentContainerInterface $container
     * @return Builder
     */
    public static function oneColumnInContainer(AbstractForm $form, ComponentContainerInterface $container): Builder
    {
        $rowFluid = new RowFluid();
        $container->addElement($rowFluid);

        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupFullWidth())
            //->addElement($container)
            ->setDefaultContainer($rowFluid);
    }

    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function simple(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupFullWidth());
    }

    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function simpleNoDefaultWidth(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroup());
    }

    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function twoColumns(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupHalfWidth())
            ->addDefaultContainer(new RowFluid());
    }

    /**
     * @param AbstractForm $form
     * @param ComponentContainerInterface $container
     * @return Builder
     */
    public static function twoColumnsInContainer(AbstractForm $form, ComponentContainerInterface $container): Builder
    {
        $rowFluid = new RowFluid();
        (new Decorator($rowFluid))->columns()->one();

        $container->addElement($rowFluid);

        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupHalfWidth())
            //->addElement($container)
            ->setDefaultContainer($rowFluid);
    }

    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function threeColumns(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupThirdWidth())
            ->addDefaultContainer(new RowFluid());
    }

    /**
     * @param AbstractForm $form
     * @param ComponentContainerInterface $container
     * @return Builder
     */
    public static function threeColumnsInContainer(AbstractForm $form, ComponentContainerInterface $container): Builder
    {
        $rowFluid = new RowFluid();
        $container->addElement($rowFluid);

        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupThirdWidth())
            ->setDefaultContainer($rowFluid);
    }

    /**
     * @param AbstractForm $form
     * @return Builder
     */
    public static function fourColumns(AbstractForm $form): Builder
    {
        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupQuarterWidth())
            ->addDefaultContainer(new RowFluid());
    }

    /**
     * @param AbstractForm $form
     * @param ComponentContainerInterface $container
     * @return Builder
     */
    public static function fourColumnsInContainer(AbstractForm $form, ComponentContainerInterface $container): Builder
    {
        $rowFluid = new RowFluid();
        $container->addElement($rowFluid);

        return (new Builder($form))
            ->setDefaultFormGroup(new FormGroupQuarterWidth())
            ->setDefaultContainer($rowFluid);
    }
}
