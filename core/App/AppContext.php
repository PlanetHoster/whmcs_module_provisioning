<?php

namespace ModulesGarden\PlanetHoster\Core\App;

use Exception;
use ModulesGarden\PlanetHoster\Core\Support\Facades\LogActivity;

class AppContext
{
    public function __construct()
    {
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Bootstrap.php';
    }

    public function runServerModule(string $callerName, $params = [])
    {
        return $this->runApp('server', $callerName, $params);
    }

    public function runAddonModule(string $callerName, $params = [])
    {
        return $this->runApp('addon', $callerName, $params);
    }

    protected function runApp(string $type, string $callerName, $params = [])
    {
        try
        {
            $app    = new Application();
            $result = $app->run($type, $callerName, $params);
        }
        catch (Exception $exc)
        {
            LogActivity::error($exc->getMessage());

            return [
                'status'  => 'error',
                'message' => $exc->getMessage(),
            ];
        }

        return $result;
    }
}
