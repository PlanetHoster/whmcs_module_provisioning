<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class ProductConfigOption extends \WHMCS\Product\ConfigOption
{
    /**
     * @deprecated - use selectableOptions
     */
    public function suboptions()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOptionSub", 'configid', "id");
    }

    public function selectableOptions()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOptionSub", "configid", "id");
    }

    public function configGroup()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigGroup", "gid", "id");
    }

    public function scopeOfProductId($query, $productId)
    {
        return $query->whereIn("gid", ProductConfigLink::ofProductId($productId)->pluck("gid"));
    }
}
