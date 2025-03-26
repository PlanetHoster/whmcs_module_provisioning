<?php

namespace ModulesGarden\PlanetHoster\Core\Contracts\Events;

interface ListenerInterface
{
    public function handle($payload = []);
}
