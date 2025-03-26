<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Listeners;

use ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update\PatchManager;
use ModulesGarden\PlanetHoster\Core\Database\FileLoader;
use ModulesGarden\PlanetHoster\Core\Events\Listener;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Config;
use ModulesGarden\PlanetHoster\Core\Support\Facades\LogActivity;
use ModulesGarden\PlanetHoster\Packages\ModuleSettings\Support\Facades\ModuleSettings;
use ModulesGarden\PlanetHoster\Packages\Product\Models\ProductConfiguration;
use Illuminate\Database\Capsule\Manager as DB;

class ConfigOptionsLoaded extends Listener
{
    public function handle($payload = [])
    {
        try
        {
            $this->createProductSettingDatabase();
            $this->addTypeColumnToProductConfiguration();
            $this->runCustomInstallQueries();
            $this->runCustomUpgradeQueries();
            $this->updateModuleVersion();
        }
        catch (\Throwable $ex)
        {
            LogActivity::error($ex->getMessage());
        }
    }

    protected function createProductSettingDatabase()
    {
        (new FileLoader())->performQueryFromFile(ModuleConstants::getFullPath('packages', 'Product', 'resources', 'database', 'schema.sql'));
    }

    protected function addTypeColumnToProductConfiguration()
    {
        $productConfigurationModel = new ProductConfiguration();
        $builder  = $productConfigurationModel->getConnection()->getSchemaBuilder();

        if (!$builder->hasColumn($productConfigurationModel->getTable(), 'type'))
        {
            $statement = "ALTER TABLE {$productConfigurationModel->getTable()} ADD type ENUM('product', 'product_addon') DEFAULT 'product' AFTER product_id";

            DB::statement($statement);
        }
    }

    protected function runCustomInstallQueries()
    {
        (new FileLoader())->performQueryFromFile(ModuleConstants::getFullPath('app', 'Database', 'schema.sql'));
        (new FileLoader())->performQueryFromFile(ModuleConstants::getFullPath('app', 'Database', 'data.sql'));
    }

    protected function runCustomUpgradeQueries()
    {
        (new PatchManager(PatchManager::TYPE_SERVER))->run(ModuleSettings::get('server.version', 0));
    }

    protected function updateModuleVersion()
    {
        ModuleSettings::save(['server.version' => Config::get('configuration.version')]);
    }
}
