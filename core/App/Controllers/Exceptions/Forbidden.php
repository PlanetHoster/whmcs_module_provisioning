<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Exceptions;

class Forbidden extends \Exception
{
    public function __construct(string $message = "", int $code = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}