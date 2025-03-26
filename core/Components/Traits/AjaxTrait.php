<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

use ModulesGarden\PlanetHoster\Core\Components\DataBuilder;
use ModulesGarden\PlanetHoster\Core\Components\Response\Response;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxAutoReloadInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxAutoSubmitInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxOnActionInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxOnLoadInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\ResponseInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;

/**
 * Class AjaxComponent
 */
trait AjaxTrait
{
    /**
     * @var int defined in milliseconds
     */
    protected int $ajaxAutoReloadInterval = 30000;
    private bool $ajaxAutoReload = false;
    private bool $ajaxOnChange = false;
    private bool $ajaxOnLoad = false;
    private bool $ajaxAutoSubmit = false;

    protected array $ajaxStoreNames = [];

    protected function ajaxStoreNamesSlotBuilder(): array
    {
        return $this->ajaxStoreNames;
    }


    protected function ajaxAutoReloadIntervalSlotBuilder(): int
    {
        return ($this instanceof AjaxAutoReloadInterface || $this->ajaxAutoReload) && $this->ajaxAutoReloadInterval > 0 ? $this->ajaxAutoReloadInterval : 0;
    }

    protected function ajaxOnActionSlotBuilder(): bool
    {
        return $this instanceof AjaxOnActionInterface || $this->ajaxOnChange;
    }

    protected function ajaxOnLoadSlotBuilder(): bool
    {
        return $this instanceof AjaxOnLoadInterface || $this->ajaxOnLoad;
    }

    protected function ajaxAutoSubmitSlotBuilder(): bool
    {
        return $this instanceof AjaxAutoSubmitInterface || $this->ajaxAutoSubmit;
    }

    /**
     * Define ajaxData that will be returned to component. This data will be used in next Ajax query
     * @param array $data
     * @return $this
     */
    public function setAjaxData(array $data)/*: self*/
    {
        $this->setSlot('ajaxData', $data);

        return $this;
    }

    protected function propagateAjaxData(): void
    {
        $this->setAjaxData((array)array_merge((array)Request::get('ajaxData'), $this->getSlot('ajaxData', [])));
    }

    public function returnAjaxData(): ResponseInterface
    {
        try
        {
            //set default ajax data
            $this->propagateAjaxData();

            return new Response(
                (new DataBuilder($this))
                    ->withHtml()
                    ->withData()
                    ->toArray()
            );
        }
        catch (\Exception $ex)
        {
            return (new Response())
                ->setError($ex->getMessage());
        }
    }
}
