<?php

namespace ModulesGarden\PlanetHoster\Core\Components\FallbackTraits;

use ModulesGarden\PlanetHoster\Core\UI\Traits\ACL;

trait BackwardCompatibilityTrait
{
    use ACL;

    public function getTemplateName()
    {
        return 'string:test';
    }

    /**
     * @param $mainContainer
     * @return void
     * @deprecated  - do not use!
     */


    public function getHtml()
    {
        return $this;
    }
}
