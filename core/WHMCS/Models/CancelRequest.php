<?php

namespace ModulesGarden\PlanetHoster\Core\WHMCS\Models;

/**
 * Description of Cancel Request
 *
 * @var int id
 * @var datetime date
 * @var int relid
 * @var string reason
 * @var string type
 * @var timestamp created_at
 * @var timestamp updated_at
 */
class CancelRequest extends \WHMCS\Service\CancellationRequest
{
    public function service()
    {
        return $this->belongsTo("ModulesGarden\PlanetHoster\Core\WHMCS\Models\Service", "relid");
    }
}
