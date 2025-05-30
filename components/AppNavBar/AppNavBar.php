<?php

namespace ModulesGarden\PlanetHoster\Components\AppNavBar;

use ModulesGarden\PlanetHoster\Components\NavBar\NavBar;
use ModulesGarden\PlanetHoster\Components\NavBarItem\NavBarItem;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

/**
 * Class Form
 */
class AppNavBar extends AbstractComponent
{
    public const COMPONENT = 'AppNavBar';

    public function __construct()
    {
        parent::__construct();

        $this->createNavbar();
    }

    private function createNavbar()
    {
        $navbar = new NavBar();
        $navbar->withPadding("");

        $this->setSlot('navbar', $navbar);
    }

    public function setModuleLogo(string $logoUrl, string $style): self
    {
        $this->setSlot('moduleLogo', $logoUrl);
        $this->setSlot('moduleIcon', $style);

        return $this;
    }

    public function setVendorLogo(string $logoUrl): self
    {
        $this->setSlot('vendorLogo', $logoUrl);

        return $this;
    }

    public function setMainUrl($mainUrl): self
    {
        $this->setSlot('mainUrl', $mainUrl);

        return $this;
    }

    public function setModuleName($name): self
    {
        $this->setSlot('moduleName', $name);

        return $this;
    }

    public function addMenuItem(NavBarItem $item): self
    {
        $this->getSlot('navbar')->addItem($item);

        return $this;
    }

    public function addToolbarElement(ComponentInterface $component): self
    {
        $this->getSlot('navbar')->addToToolbar($component);

        return $this;
    }
}
