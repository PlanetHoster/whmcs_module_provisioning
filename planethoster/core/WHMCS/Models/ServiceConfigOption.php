<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class ServiceConfigOption extends \WHMCS\Service\ConfigOption
{
    public function productConfigOptionSelection()
    {
        return $this->hasOne("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOptionSub", "id", "optionid");
    }

    public function productConfigOption()
    {
        return $this->hasOne("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigOption", "id", "configid");
    }

    public function service()
    {
        return $this->hasOne("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service", "id", "relid");
    }
}