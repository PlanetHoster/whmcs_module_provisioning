<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class Contact extends \WHMCS\User\Client\Contact
{
    public function client()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Client", "userid");
    }

    public function orders()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Order", "id", "orderid");
    }
}
