<?php

namespace ModulesGarden\PlanetHoster\App\Libs\Managers;

use ModulesGarden\PlanetHoster\Core\WHMCS\Models\CustomField;
use ModulesGarden\PlanetHoster\Core\WHMCS\Models\CustomFieldValue;

class ProductCustomFields
{
    const PROV_CUSTOM_FIELD_TYPE = 'product';

    protected $productId = null;

    protected $serviceId = null;

    protected $fieldsList = [];

    public function __construct(int $productId = null, int $serviceId = null)
    {
        $this->setProductId($productId);
        $this->setServiceId($serviceId);

        $this->loadFieldsList();
    }

    protected function setProductId($productId = null)
    {
        $relationId = (int)$productId;
        if ($relationId <= 0)
        {
            throw new \Exception('Invalid Product Id');
        }

        $this->productId = $relationId;
    }

    protected function setServiceId($serviceId = null)
    {
        $relationId = (int)$serviceId;
        if ($relationId <= 0)
        {
            throw new \Exception('Invalid Service Id');
        }

        $this->serviceId = $relationId;
    }

    protected function loadFieldsList()
    {
        $fieldModel = new CustomField();

        $fieldsResult = $fieldModel->where('type', self::PROV_CUSTOM_FIELD_TYPE)
            ->where('relid', $this->productId)->get();

        if (!$fieldsResult)
        {
            return;
        }

        $list = $fieldsResult->toArray();

        $parsedList = [];
        foreach ($list as $field)
        {
            $parts                 = explode('|', $field['fieldname']);
            $parsedList[$parts[0]] = $field;
        }

        $this->fieldsList = $parsedList;
    }

    public function getFieldsList()
    {
        return $this->fieldsList;
    }

    public function getCustomFieldsValue($fieldName)
    {
        $fieldName             = explode('|', $fieldName)[0];
        $customFieldValueModel = new CustomFieldValue();
        $field                 = $this->fieldsList[$fieldName];
        $result                = $customFieldValueModel->where('fieldid', $field['id'])->where('relid', $this->serviceId)->get();

        if ($result)
        {
            return $result[0]->value;
        }
        return false;
    }

    public function updateFieldValue($fieldName, $newValue = '')
    {
        $nameParts = explode('|', $fieldName);

        $fieldName = $nameParts[0];
        if (!isset($this->fieldsList[$fieldName]))
        {
            throw new \Exception('Invalid Custom Field');
        }

        $field = $this->fieldsList[$fieldName];

        $customFieldValueModel = new CustomFieldValue();
        $count                 = $customFieldValueModel->where('fieldid', $field['id'])->where('relid', $this->serviceId)->count();

        if ($count > 0)
        {
            return $customFieldValueModel->where('fieldid', $field['id'])->where('relid', $this->serviceId)->update(['value' => $newValue]);
        }

        $customFieldValueModel = new CustomFieldValue();

        return $customFieldValueModel->fill([
            'fieldid' => $field['id'],
            'relid'   => $this->serviceId,
            'value'   => $newValue
        ])->save();
    }
}