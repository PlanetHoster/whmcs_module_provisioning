<?php

namespace ModulesGarden\PlanetHoster\Components\Graph\Models;

use Illuminate\Contracts\Support\Arrayable;
use ModulesGarden\PlanetHoster\Core\HandlerError\ErrorCodes\ErrorCodesLib;
use ModulesGarden\PlanetHoster\Core\HandlerError\Exceptions\Exception;

class Options implements Arrayable
{
    public const GRAPH_FILTER_TYPE_DATE     = 'date';
    public const GRAPH_FILTER_TYPE_INT      = 'int';
    public const GRAPH_FILTER_TYPE_STRING   = 'string';
    public const GRAPH_OPTIONS_MODE_DATASET = 'dataset';
    public const GRAPH_OPTIONS_MODE_INDEX   = 'index';
    public const GRAPH_OPTIONS_MODE_NEAREST = 'nearest';
    public const GRAPH_OPTIONS_MODE_POINT   = 'point';
    public const GRAPH_OPTIONS_MODE_X       = 'x';
    public const GRAPH_OPTIONS_MODE_Y       = 'y';
    protected array $animation = [];
    protected $filterInfo = [
        'displayEditColor' => true,
        'type'             => self::GRAPH_FILTER_TYPE_INT,
        'default'          => [
            'start' => 0,
            'end'   => 100,
        ],
    ];
    protected $layout = [];
    protected $legend = [
        'display'  => true,
        'position' => 'top',
    ];
    protected $responsive = true;
    protected $scales = [
        'xAxes' => [
            [
                'ticks' => [
                    'beginAtZero' => true,
                ],
            ],
        ],
    ];
    protected $titleGraph = [
        'display'  => false,
        'text'     => '',
        'position' => 'top',
    ];
    protected $tooltips = [
        'mode' => self::GRAPH_OPTIONS_MODE_INDEX,
    ];

    public function setTitleDisplay($display = true)
    {
        $this->titleGraph['display'] = (bool)$display;

        return $this;
    }

    public function setTitleFontColor($fontColor = '#666')
    {
        $this->titleGraph['fontColor'] = (string)$fontColor;

        return $this;
    }

    public function setTitleFontFamily($fontFamily = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif")
    {
        $this->titleGraph['fontFamily'] = (string)$fontFamily;

        return $this;
    }

    public function setTitleFontSize($fontSize = 12)
    {
        $this->titleGraph['fontSize'] = (int)$fontSize;

        return $this;
    }

    public function setTitleFontStyle($fontStyle = '')
    {
        $this->titleGraph['fontStyle'] = (string)$fontStyle;

        return $this;
    }

    public function setTitleLineHeight($lineHeight = 1.2)
    {
        $this->titleGraph['lineHeight'] = (float)$lineHeight;

        return $this;
    }

    public function setTitlePadding($padding = '')
    {
        $this->titleGraph['padding'] = (string)$padding;

        return $this;
    }

    public function setTitlePosition($position = 'top')
    {
        $this->titleGraph['position'] = (string)$position;

        return $this;
    }

    public function setTitleText($text = '')
    {
        $this->titleGraph['text'] = (string)$text;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title'      => $this->titleGraph,
            'scales'     => $this->scales,
            'legend'     => $this->legend,
            'tooltips'   => $this->tooltips,
            'layout'     => $this->layout,
            'animation'  => !empty($this->animation) ? $this->animation : null,
            'responsive' => $this->responsive,
        ];
    }

    protected function addAnimation($event, $animation)
    {
        if (is_array($this->animation))
        {
            $this->animation[$event] = $animation;
        }
        elseif (is_string($this->animation))
        {
            $animations         = json_decode($this->animation, true);
            $animations[$event] = $animation;
            $this->animation    = json_encode($animations);
        }

        return $this;
    }

    protected function addChartScale($key = null, array $scales = [])
    {
        if (trim($key) !== '' && is_string($key) && !isset($this->scales[$key]))
        {
            $this->scales[$key] = $scales;
        }

        return $this;
    }

    protected function disableEditColor()
    {
        $this->filterInfo['displayEditColor'] = false;

        return $this;
    }

    protected function enableEditColor()
    {
        $this->filterInfo['displayEditColor'] = true;

        return $this;
    }

    protected function setAnimation($animation)
    {
        $this->animation = $animation;

        return $this;
    }

    protected function setChartScales(array $scales = [])
    {
        $this->scales = $scales;

        return $this;
    }

    protected function setGraphFilterInfo($type = self::GRAPH_FILTER_TYPE_INT, $defaultStart = 0, $defaultStop = 100)
    {
        if ($type !== null && in_array($type, [self::GRAPH_FILTER_TYPE_INT, self::GRAPH_FILTER_TYPE_DATE, self::GRAPH_FILTER_TYPE_STRING], true))
        {
            $this->filterInfo['type'] = $type;
        }

        if ($defaultStart !== null)
        {
            $this->filterInfo['default']['start'] = $defaultStart;
        }

        if ($defaultStop !== null)
        {
            $this->filterInfo['default']['end'] = $defaultStop;
        }

        return $this;
    }

    protected function setLayoutPadding($left = 0, $right = 0, $top = 0, $bottom = 0)
    {
        $this->layout['padding'] = [
            'left'   => $left,
            'right'  => $right,
            'top'    => $top,
            'bottom' => $bottom,
        ];

        return $this;
    }

    protected function setLegendDisplay($isDisplay = true)
    {
        $this->legend['display'] = (bool)$isDisplay;

        return $this;
    }

    protected function setLegendFullWidth($isFullWidth = true)
    {
        $this->legend['fullWidth'] = (bool)$isFullWidth;

        return $this;
    }

    protected function setLegendLabelsBoxWidth($boxWidth)
    {
        $this->legend['labels']['boxWidth'] = (int)$boxWidth;

        return $this;
    }

    protected function setLegendLabelsFilter($filter = 'function () {}')
    {
        $this->legend['labels']['filter'] = (string)$filter;

        return $this;
    }

    protected function setLegendLabelsFontColor($fontColor)
    {
        $this->legend['labels']['fontColor'] = (string)$fontColor;

        return $this;
    }

    protected function setLegendLabelsFontFamily($fontFamily = "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif")
    {
        $this->legend['labels']['fontFamily'] = (string)$fontFamily;

        return $this;
    }

    protected function setLegendLabelsFontSize($fontSize)
    {
        $this->legend['labels']['fontSize'] = (int)$fontSize;

        return $this;
    }

    protected function setLegendLabelsFontStyle($fontStyle)
    {
        $this->legend['labels']['fontStyle'] = (string)$fontStyle;

        return $this;
    }

    protected function setLegendLabelsGenerateLabels($generateLabels = 'function () {}')
    {
        $this->legend['labels']['generateLabels'] = (string)$generateLabels;

        return $this;
    }

    protected function setLegendLabelsPadding($padding = 10)
    {
        $this->legend['labels']['padding'] = (int)$padding;

        return $this;
    }

    protected function setLegendLabelsUsePointStyle($usePointStyle = false)
    {
        $this->legend['labels']['usePointStyle'] = (bool)$usePointStyle;

        return $this;
    }

    protected function setLegendOnClick($eventFunction = 'function (event, legendItem) {}')
    {
        $this->legend['onClick'] = (string)$eventFunction;

        return $this;
    }

    protected function setLegendOnHover($eventFunction = 'function (event, legendItem) {}')
    {
        $this->legend['onHover'] = (string)$eventFunction;

        return $this;
    }

    protected function setLegendPosition($position = 'top')
    {
        $this->legend['position'] = (string)$position;

        return $this;
    }

    protected function setLegendReverse($isReverse = false)
    {
        $this->legend['reverse'] = (bool)$isReverse;

        return $this;
    }

    protected function setTooltipsMode($tooltipMode = 'index')
    {
        if (!in_array($tooltipMode, [self::GRAPH_OPTIONS_MODE_DATASET, self::GRAPH_OPTIONS_MODE_INDEX, self::GRAPH_OPTIONS_MODE_NEAREST, self::GRAPH_OPTIONS_MODE_POINT, self::GRAPH_OPTIONS_MODE_X, self::GRAPH_OPTIONS_MODE_Y]))
        {
            throw new Exception(ErrorCodesLib::CORE_GRA_000001, ['mode' => $tooltipMode]);
        }

        $this->tooltips['mode'] = $tooltipMode;

        return $this;
    }

    protected function updateChartScale($key = null, array $scales = [])
    {
        if (trim($key) !== '' && is_string($key))
        {
            $this->scales[$key] = $scales;
        }

        return $this;
    }
}
