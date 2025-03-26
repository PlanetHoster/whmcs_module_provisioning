<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Tools;

use ModulesGarden\PlanetHoster\Core\Contracts\Components\ComponentInterface;

class IdGenerator
{
    private static array $ids = [];

    public static function generate(ComponentInterface $component): string
    {
        return self::generateIdAndPush(get_class($component));
    }

    protected static function generateIdAndPush(string $className): string
    {
        $suffix    = 1;
        $defaultId = substr(sha1($className), 0, 16);
        $id        = $defaultId;

        while (self::isExists($id))
        {
            $id = $defaultId . '_' . ($suffix++);
        }

        self::push($id);

        return $id;
    }

    protected static function isExists($id): bool
    {
        return in_array($id, self::$ids);
    }

    protected static function push($id)
    {
        self::$ids[] = $id;
    }
}