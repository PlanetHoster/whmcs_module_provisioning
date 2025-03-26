<?php

namespace ModulesGarden\PlanetHoster\Components\DatePicker;

use ModulesGarden\PlanetHoster\Core\Components\FormFields\FormField;

/**
 * Class IconButton
 */
class DatePicker extends FormField
{
    public const COMPONENT    = 'DatePicker';
    public const FORMAT_Y_M_D = 'yyyy-MM-dd';

    public function __construct()
    {
        parent::__construct();

        $this->setDateFormat(self::FORMAT_Y_M_D);
    }

    public function setDateFormat($dateFormat)
    {
        $this->setSlot('format', $dateFormat);
    }
}
