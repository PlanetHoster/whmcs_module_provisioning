<?php

namespace ModulesGarden\PlanetHoster\Core\Components;

use ModulesGarden\PlanetHoster\Components\Form\AbstractForm;
use ModulesGarden\PlanetHoster\Core\Components\Actions\FormSubmit;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalClose;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalFormSubmit;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalLoad;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ModalOpen;
use ModulesGarden\PlanetHoster\Core\Components\Actions\Redirect;
use ModulesGarden\PlanetHoster\Core\Components\Actions\Reload;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ReloadById;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ReloadParent;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

/**
 * @todo to na razie jest tylko wersja robocza, przerobić później na pod obiekty (factory)
 */
class Action
{
    public static function modalLoad($modal): ModalLoad
    {
        return new ModalLoad($modal);
    }

    public static function modalOpen($modal): ModalOpen
    {
        return new ModalOpen($modal);
    }

    public static function redirect(string $url): Redirect
    {
        return new Redirect($url);
    }

    public static function reload(ComponentInterface $element): Reload
    {
        return new Reload($element);
    }

    public static function reloadById($componentId): ReloadById
    {
        return new ReloadById($componentId);
    }

    public static function reloadParent(): ReloadParent
    {
        return new ReloadParent();
    }
}
