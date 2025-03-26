<?php

namespace ModulesGarden\PlanetHoster\Core\Services;


class Request extends \ModulesGarden\PlanetHoster\Core\Http\Request
{
    public function getAll()
    {
        return $this->request->all();
    }
}
