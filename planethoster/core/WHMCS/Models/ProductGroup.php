<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class ProductGroup extends \WHMCS\Product\Group
{
    public function products()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product", 'gid');
    }
}
