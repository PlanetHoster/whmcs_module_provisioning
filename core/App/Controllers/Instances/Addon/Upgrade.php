<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon;

use ModulesGarden\PlanetHoster\Core\Events\Events\AfterModuleUpgraded;
use ModulesGarden\PlanetHoster\Core\Events\Events\ModuleUpgraded;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update\After;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update\Before;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update\PatchManager;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AddonControllerInterface;
use ModulesGarden\PlanetHoster\Core\Events\Events\PreModuleUpgraded;
use ModulesGarden\PlanetHoster\Core\ServiceLocator;
use ModulesGarden\PlanetHoster\Core\Support\Facades\LogActivity;
use function ModulesGarden\PlanetHoster\Core\fire;

/**
 * module update process
 */
class Upgrade extends \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController implements AddonControllerInterface
{
    public function execute($params = [])
    {
        $version = isset($this->params['version']) ? $this->params['version'] : $params['version'];

        try
        {
            fire(PreModuleUpgraded::class);

            // after
            $return = ServiceLocator::call(After::class)->execute(['version' => $version]);

            // update
            if (!isset($return['version']))
            {
                $return['version'] = $version;
            }
            (new PatchManager())->run($version);

            // before
            $return = ServiceLocator::call(Before::class)->execute($return);

            fire(ModuleUpgraded::class);
            fire(AfterModuleUpgraded::class);

            return $return;
        }
        catch (\Throwable $exc)
        {
            LogActivity::error($exc->getMessage());
        }
    }
}
