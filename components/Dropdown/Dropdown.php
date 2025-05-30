<?php

namespace ModulesGarden\PlanetHoster\Components\Dropdown;

use ModulesGarden\PlanetHoster\Core\Components\FormFields\FormField;
use ModulesGarden\PlanetHoster\Core\Components\Traits\OptionsTrait;
use ModulesGarden\PlanetHoster\Core\Components\Traits\ActionOnChangeItemTrait;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AvailableOptionsInterface;

class Dropdown extends FormField implements AvailableOptionsInterface
{
    use OptionsTrait;
    use ActionOnChangeItemTrait;

    public const COMPONENT = 'Dropdown';

    public function __construct()
    {
        parent::__construct();

        $this->setTranslations([
            'search_placeholder',
            'static_placeholder',
            'tagger_placeholder'
        ]);
    }

    public function setAjaxOnLoad($setAjaxOnLoad = true)
    {
        $this->setSlot('ajax_on_load', $setAjaxOnLoad);
    }

    public function setAjaxSearch($isAjaxSearch = true)
    {
        $this->setSlot('ajaxSearch', $isAjaxSearch);
    }

    public function setAllowToCreate($allowToCreate = true): self
    {
        $this->setSlot('tagger', true);

        return $this;
    }

    public function setMultiple($isMultiple = true): self
    {
        $this->setSlot('multiple', $isMultiple);

        return $this;
    }

    public function setPlaceholder($placeholder): self
    {
        $this->setSlot('placeholder', $placeholder);

        return $this;
    }

    public function setGroups(array $groups): self
    {
        $this->setSlot('groups', $this->convertOptions($groups));

        return $this;
    }
}
