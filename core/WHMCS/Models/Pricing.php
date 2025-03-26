<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class Pricing extends \WHMCS\Billing\Pricing
{
    public function currencyModel()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Currency", 'currency');
    }

    /**
     * Adds query condition to limit result records only to domains pricing
     */
    public function domainPricing()
    {
        $this->whereIn('tblpricing.type', ['domaintransfer', 'domainrenew', 'domainregister']);

        return $this;
    }
}
