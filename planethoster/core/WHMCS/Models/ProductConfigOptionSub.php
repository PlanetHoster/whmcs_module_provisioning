<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class ProductConfigOptionSub extends \WHMCS\Product\ConfigOptionSelection
{
    public function configOption()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOption", 'configid');
    }
}
