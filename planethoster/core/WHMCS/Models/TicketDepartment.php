<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

class TicketDepartment extends \WHMCS\Support\Department
{
    public function tickets()
    {
        return $this->hasMany('ModulesGarden\PlanetHoster\Core\WHMCS\Models\Ticket', "did");
    }
}
