<?php

namespace ModulesGarden\PlanetHoster\Core\Http;

use ModulesGarden\PlanetHoster\Core\Traits\IsAdmin;
use ModulesGarden\PlanetHoster\Core\Traits\OutputBuffer;

/**
 * Description of AbstractController
 */
class AbstractController
{
    use IsAdmin;
    use OutputBuffer;
}
