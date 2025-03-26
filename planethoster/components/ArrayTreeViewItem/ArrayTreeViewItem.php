<?php

namespace ModulesGarden\PlanetHoster\Components\ArrayTreeViewItem;

use ModulesGarden\PlanetHoster\Components\ArrayTreeView\Traits\ElementsExpanderTrait;
use ModulesGarden\PlanetHoster\Components\ArrayTreeView\Traits\ElementsPrefixTrait;
use ModulesGarden\PlanetHoster\Components\ArrayTreeView\Traits\ExpanderOnBeginningTrait;
use ModulesGarden\PlanetHoster\Components\ArrayTreeView\Traits\HiddenKeysModeTrait;
use ModulesGarden\PlanetHoster\Components\ArrayTreeView\Traits\KeyValueSeparatorTrait;
use ModulesGarden\PlanetHoster\Core\Components\AbstractComponent;

class ArrayTreeViewItem extends AbstractComponent
{
    use ElementsPrefixTrait;
    use KeyValueSeparatorTrait;
    use ElementsExpanderTrait;
    use ExpanderOnBeginningTrait;
    use HiddenKeysModeTrait;

    public const COMPONENT = 'ArrayTreeViewItem';

    protected mixed $value;

    public function __construct(string $key, mixed $value = null)
    {
        parent::__construct();

        $this->setSlot("name", $key);
        $this->value = $value;
    }

    final public function valueSlotBuilder():mixed
    {
        return $this->buildValue();
    }

    protected function buildValue():mixed
    {
        if (!is_array($this->value))
        {
            return $this->value;
        }

        $this->setSlot("hasElements", true);

        $elements = [];

        foreach ($this->value as $key => $value)
        {
            $elements[] = (new ArrayTreeViewItem($key, $value))
                ->setElementsPrefix($this->elementsPrefix)
                ->setKeyValueSeparator($this->keyValueSeparator)
                ->setElementsExpander($this->elementsExpander)
                ->enableExpanderOnBeginning($this->expanderOnBeginning)
                ->enableHiddenKeysMode($this->hiddenKeysMode);
        }

        return $elements;
    }
}