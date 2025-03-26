<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Addon;

use Exception;
use ModulesGarden\PlanetHoster\Core\Events\Events\AfterModuleActivated;
use ModulesGarden\PlanetHoster\Core\Events\Events\ModuleActivated;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Activate\After;
use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Activate\Before;
use ModulesGarden\PlanetHoster\Core\Contracts\Controllers\AddonControllerInterface;
use ModulesGarden\PlanetHoster\Core\Database\FileLoader;
use ModulesGarden\PlanetHoster\Core\Events\Events\PreModuleActivated;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\ServiceLocator;
use ModulesGarden\PlanetHoster\Core\Support\Facades\LogActivity;
use function ModulesGarden\PlanetHoster\Core\fire;

/**
 * Activate module actions
 */
class Activate extends \ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController implements AddonControllerInterface
{
    public function execute($params = [])
    {
        try
        {
            fire(PreModuleActivated::class);

            //Before module activation
            $return = ServiceLocator::call(Before::class)->execute($params);
            if (!isset($return['status']))
            {
                $return['status'] = 'success';
            }

            //module activation process
            $return = $this->activate($return);

            //After module activation
            $return = ServiceLocator::call(After::class)->execute($return);


            fire(ModuleActivated::class);
            fire(AfterModuleActivated::class);

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

    protected function activate($params = [])
    {
        $fileLoader = new FileLoader();

        if ($params['status'] === 'error')
        {
            return $params;
        }

        try
        {
            $fileLoader->performQueryFromFile(ModuleConstants::getFullPath('app', 'Database', 'schema.sql'));
            $fileLoader->performQueryFromFile(ModuleConstants::getFullPath('app', 'Database', 'data.sql'));
        }
        catch (\Exception $ex)
        {
            LogActivity::error($ex->getMessage());
            return ['status' => 'error', 'description' => $ex->getMessage()];
        }

        return ['status' => 'success'];
    }
}
