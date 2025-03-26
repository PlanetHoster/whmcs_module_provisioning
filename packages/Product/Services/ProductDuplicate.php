<?php

namespace ModulesGarden\PlanetHoster\Packages\Product\Services;

use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\Product;
use ModulesGarden\PlanetHoster\Packages\ModuleSettings\Support\Facades\ModuleSettings;
use ModulesGarden\PlanetHoster\Packages\Product\Helpers\ProductConfiguration as ProductConfigurationSupport;

class ProductDuplicate
{
    protected $productId;

    public function __construct($productId)
    {
        if (!is_numeric($productId))
        {
            throw new \InvalidArgumentException("The product id must be defined.");
        }

        $this->productId = $productId;
    }

    public static function checkAndInitDuplicateProcess()
    {
        if (Request::get('action') == "duplicatenow" && Request::get('existingproduct') && Request::get('newproductname'))
        {
            try
            {
                ModuleSettings::save(["duplicateProduct" => json_encode(Request::request()->all())]);
            }
            catch (\Exception $ex)
            {
            }
        }
    }

    public function replicate(array $settings = [])
    {
        $product = Product::where("id", $this->productId)->where("name", $settings['newproductname'])->first();

        if (!$product->exists || !ProductConfigurationSupport::isSupported($product->servertype))
        {
            return;
        }

        $newConfigs = new ProductConfiguration($this->productId);

        if (!empty($newConfigs->get()))
        {
            return;
        }

        $newConfigs->save((new ProductConfiguration($settings['existingproduct']))->get());
    }
}