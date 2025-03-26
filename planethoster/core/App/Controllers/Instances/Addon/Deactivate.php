<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon;

use Exception;
use ModulesGarden\PlanetHoster\Core\Events\Events\ModuleDeactivated;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AddonControllerInterface;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Deactivate\After;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Deactivate\Before;
use ModulesGarden\PlanetHoster\Core\ServiceLocator;
use ModulesGarden\PlanetHoster\Core\Support\Facades\LogActivity;
use function ModulesGarden\PlanetHoster\Core\fire;

/**
 * Deactivate module action
 */
class Deactivate extends \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController implements AddonControllerInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function execute($params = [])
    {
        try
        {
            // before
            $return = ServiceLocator::call(Before::class)->execute($params);

            if (!isset($return['status']))
            {
                $return['status'] = 'success';
            }

            // after
            $return = ServiceLocator::call(After::class)->execute($return);

            fire(ModuleDeactivated::class);

            return $return;
        }
        catch (\Throwable $exc)
        {
            LogActivity::error($exc->getMessage());

            return [
                'status'      => 'error',
                'description' => $exc->getMessage(),
            ];
        }
    }
}
