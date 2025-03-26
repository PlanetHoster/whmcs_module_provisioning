<?php

namespace ModulesGarden\PlanetHoster\Core\DataProviders;

use ModulesGarden\PlanetHoster\Core\Contracts\CrudProviderInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Validator;
use ModulesGarden\PlanetHoster\Core\Translation\TranslatorTrait;

class CrudProvider implements CrudProviderInterface
{
    use TranslatorTrait;

    public const ACTION_CREATE = 'create';
    public const ACTION_DELETE = 'delete';
    public const ACTION_READ   = 'read';
    public const ACTION_UPDATE = 'update';
    protected ?string $actionElementId;
    protected DataContainer $availableValues;

    /**
     * @var DataContainer
     */
    protected DataContainer $data;

    /**
     * @var DataContainer
     */
    protected DataContainer $formData;

    protected DataContainer $ajaxData;

    public function __construct()
    {
        $this->formData        = new DataContainer((array)\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get('formData', []));
        $this->ajaxData        = new DataContainer((array)\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get('ajaxData', []));
        $this->data            = new DataContainer();
        $this->availableValues = new DataContainer();

        $this->actionElementId = $this->formData->get('id');
    }

    public function create()
    {
    }

    public function delete()
    {
    }

    public function read()
    {
        $this->data = clone $this->formData;
    }

    public function update()
    {
    }

    final public function getAvailableValuesById($name): array
    {
        return $this->availableValues->get($name, []);
    }

    final public function getValueById($name)
    {
        return $this->data->get($name);
    }

    protected function validate(array $data, array $rules, array $translationAttributes = [])
    {
        $customAttributes = [];
        $customValues     = [];

        foreach ($translationAttributes as $attribute => $values)
        {
            $customAttributes[$attribute] = $this->translate("attributes.$attribute");

            foreach ($values as $value)
            {
                $customValues[$attribute][$value] = $this->translate("values.$attribute.$value");
            }
        }

        Validator::validate($data, $rules, $customAttributes, $customValues);
    }
}
