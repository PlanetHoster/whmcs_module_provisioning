<?php

namespace ModulesGarden\PlanetHoster\Core\Traits;

/**
 * @deprecated
 */
trait IsAdmin
{
    /**
     * @var null|bool
     * determines if run in Admin or Client context
     * @deprecated
     */
    protected $isAdminStatus = null;

    /**
     * return bool
     */
    public function isAdmin()
    {
        if ($this->isAdminStatus === null)
        {
            $this->isAdminStatus = \ModulesGarden\PlanetHoster\Core\Helper\isAdmin();
        }

        return $this->isAdminStatus;
    }
}
