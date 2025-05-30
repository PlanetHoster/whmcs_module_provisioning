<?php

namespace ModulesGarden\PlanetHoster\Core\UI\PageParams;

use ModulesGarden\PlanetHoster\Core\UI\PageParams\ModuleActions\DefaultAction;
use ModulesGarden\PlanetHoster\Core\UI\PageParams\Source\ModuleActionInterface;

class ModuleActionsFactory
{
    const ACTIONS_DIR = 'ModuleActions';

    public static function getFromParams(array $params = []): ModuleActionInterface
    {
        if (empty($params['action']))
        {
            return new DefaultAction();
        }

        $actionName = $params['action'];

        $className = __NAMESPACE__ . '\\' . self::ACTIONS_DIR . '\\' . $actionName;

        if (!class_exists($className) )
        {
            return new DefaultAction();
        }

        $actionObject = new $className();

        if (!is_subclass_of($actionObject,ModuleActionInterface::Class ))
        {
            return new DefaultAction();
        }

        return $actionObject;
    }
}