<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class Service extends \WHMCS\Service\Service
{
    public function addons()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ServiceAddon", 'hostingid');
    }

    public function cancellationRequests()
    {
        return $this->hasOne("ModulesGarden\PlanetHoster\Core\WHMCS\Models\CancelRequest", 'relid');
    }

    public function client()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Client", 'userid');
    }

    public function configOptions()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\ServiceConfigOption", 'relid');
    }

    public function customFieldValues()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\CustomFieldValue", "relid");
    }

    public function order()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Order", 'orderid');
    }

    public function product()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product", 'packageid');
    }

    public function server()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Server", 'server');
    }

    public function promotion()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Promotion", "id", "promoid");
    }

    public function paymentGateway()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\PaymentGateway", "gateway", "paymentmethod");
    }
}