<?php

namespace ModulesGarden\PlanetHoster\Core\Configuration\Addon\Update\Patch;

use ModulesGarden\PlanetHoster\Core\Database\FileLoader;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

/**
 * Description of AbstractPatch
 */
class AbstractPatch
{
    protected $version;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $versionName;

    public function __construct()
    {
        $this->path        = ModuleConstants::getModuleRootDir() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Database';
        $this->versionName = end(explode('\\', get_called_class()));
    }

    public function execute()
    {
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version = null)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return bool
     */
    protected function runData()
    {
        return ((new FileLoader())->performQueryFromFile($this->path . DIRECTORY_SEPARATOR . $this->versionName . DIRECTORY_SEPARATOR . 'data.sql') === true)
            ? false
            : true;
    }

    /**
     * @return bool
     */
    protected function runSchema()
    {
        return ((new FileLoader())->performQueryFromFile($this->path . DIRECTORY_SEPARATOR . $this->versionName . DIRECTORY_SEPARATOR . 'schema.sql') === true)
            ? false
            : true;
    }
}
