<?php

namespace ModulesGarden\PlanetHoster\Core\Support\Facades;


use ModulesGarden\PlanetHoster\Core\UI\Breadcrumbs\Item;

/**
 * @method static add(Item $item);
 * @method static set(array $items);
 * @method static get();
 * @method static delete(int $index);
 * @method static clear();
 * @method static addSuffixToLast(string $text);
 * @method static addPrefixToLast(string $text);
 */
class Breadcrumbs extends AbstractFacade
{
    protected static function getFacadeAccessor(): string
    {
        return \ModulesGarden\PlanetHoster\Core\Services\Breadcrumbs::class;
    }
}
