<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class Invoice extends \WHMCS\Billing\Invoice
{
    public function client()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Client", 'userid');
    }

    public function items()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\InvoiceItem", 'invoiceid');
    }

    public function order()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Order", 'id', 'invoiceid');
    }

    public function transactions()
    {
        return $this->hasMany("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Transaction", 'invoiceid');
    }

    public function getAmountpaidAttribute()
    {
        $total = 0;
        foreach ($this->transactions as $trans)
        {
            $total += $trans->amountin - $trans->amountout;
        }

        return $total;
    }
}
