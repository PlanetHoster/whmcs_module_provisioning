<?php

namespace ModulesGarden\PlanetHoster\Core\Components\Traits;

trait OptionsTrait
{
    /**
     * Available options to choose
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->setSlot('options', $this->convertOptions($options));

        return $this;
    }

    /**
     * Take first value from provided options and set it as default.
     * @return $this
     */
    public function setDefaultValueAsFirstOption(): self
    {
        $this->setSlot('setDefaultValueAsFirstOption', true);

        return $this;
    }

    protected function convertOptions(array $options): array
    {
        $converted = [];
        $first = current($options);

        if (!empty($first['value']))
        {
            return array_values($options);
        }

        foreach ($options as $value => $name)
        {
            $converted[] = [
                'name'  => $name,
                'value' => $value,
            ];
        }

        return $converted;
    }

}