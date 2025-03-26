<?php

namespace ModulesGarden\PlanetHoster\Core\Helper\Currency;

use ModulesGarden\PlanetHoster\Core\Helper\Currency\Models\Format;

class Formatter
{
    protected string $prefix;
    protected string $suffix;
    protected Format $format;

    public function __construct(string $prefix = "", string $suffix = "", ?Format $format = null)
    {
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->format = $format ?: new Format();
    }

    public function format(float $price, ?string $prefix = null, ?string $suffix  = null, ?Format $format  = null):string
    {
        $formatted = $this->getFormatted($price, $format ?: $this->format);

        return ($prefix ?: $this->prefix) . $formatted . ($suffix ?: $this->suffix);
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @param string $suffix
     */
    public function setSuffix(string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    /**
     * @param Format $format
     */
    public function setFormat(Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    protected function getFormatted(float $price, Format $format):string
    {
        return number_format(
            $price,
            $format->getDecimals(),
            $format->getDecimalSeparator(),
            $format->getThousandsSeparator()
        );
    }
}