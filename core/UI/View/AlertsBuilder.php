<?php

namespace ModulesGarden\PlanetHoster\Core\UI\View;

use ModulesGarden\PlanetHoster\Components\Alert\Alert;
use ModulesGarden\PlanetHoster\Core\Services\Messages;
use function ModulesGarden\PlanetHoster\Core\make;

class AlertsBuilder
{
    public function create(): array
    {
        $alerts = [];
        foreach (make(Messages::class)->getAlerts() as $message)
        {
            $alerts[] = (new Alert())
                ->setText($message->getText())
                ->setType($message->getType())
                ->setOutline();
        }

        return $alerts;
    }
}