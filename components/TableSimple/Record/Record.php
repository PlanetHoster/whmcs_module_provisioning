<?php

namespace ModulesGarden\PlanetHoster\Components\TableSimple\Record;

class Record
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function toArray()
    {
        return $this->data;
    }
}
