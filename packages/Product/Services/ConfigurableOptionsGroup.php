<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Services;

use ModulesGarden\PlanetHoster\App\Http\Actions\MetaData;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;
use ModulesGarden\PlanetHoster\Core\Support\Arr;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigGroup;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\ProductConfigLink;

class ConfigurableOptionsGroup
{
    use TranslatorTrait;

    public function getFirstOrCreateRelated(Product $product): ProductConfigGroup
    {
        $group = ProductConfigGroup::ofProductId($product->id)->first();
        if (!$group->exists)
        {
            return $this->createProductRelatedConfigOptionsGroup($product);
        }

        return $group;
    }

    protected function createProductRelatedConfigOptionsGroup(Product $product)
    {
        $newGroup = ProductConfigGroup::create([
            'name'        => $this->translate('autoGenerateGroupName', [
                'productName' => $product->name
            ]),
            'description' => $this->translate('autoGenerateGroupDescription', [
                'moduleName' => Arr::get((new MetaData())->execute(), 'DisplayName', ModuleConstants::getModuleName())
            ]),
        ]);

        if (is_int($newGroup->id) && $newGroup->id > 0)
        {
            ProductConfigLink::create(['gid' => $newGroup->id, 'pid' => $product->id]);
        }

        return $newGroup;
    }
}