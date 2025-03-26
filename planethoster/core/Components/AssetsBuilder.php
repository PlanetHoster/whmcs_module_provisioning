<?php

namespace ModulesGarden\PlanetHoster\Core\Components;

use ModulesGarden\PlanetHoster\Core\Components\Builder\FileFinder;
use ModulesGarden\PlanetHoster\Core\ModuleConstants;

class AssetsBuilder
{
    protected $components = [];
    protected $htmlContent = '';
    protected $jsContent = '';

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $files = scandir(ModuleConstants::getFullPath('components'));

        foreach ($files as $file)
        {
            if (in_array($file, ['.', '..']))
            {
                continue;
            }

            $this->components[] = '\ModulesGarden\PlanetHoster\Components\\' . $file . '\\' . $file;
        }
    }

    /**
     * @return $this
     */
    public function build()
    {
        $this->jsContent   = '';
        $this->htmlContent = 'let templateContent = []'.PHP_EOL;

        foreach ($this->components as $component)
        {
            $this->htmlContent .= $this->buildHtml($component);
            $this->jsContent   .= $this->buildJs($component);
        }

        return $this;
    }

    /**
     * @param string $component
     * @return string
     */
    protected function buildHtml(string $component)
    {
        return sprintf('templateContent["%s"] = `%s`', $this->getTemplateName($component), (new FileFinder($component))->getHtml()) . PHP_EOL;
    }

    /**
     * @param string $component
     * @return string
     */
    protected function getTemplateName(string $component): string
    {
        return $component::getComponentTemplateName();
    }

    /**
     * @param string $component
     * @return string
     */
    protected function buildJs(string $component)
    {
        $js = ((new FileFinder($component))->getJs());
        $js = str_replace("'#template-name#'", sprintf('templateContent["%s"]', $this->getTemplateName($component)), $js);
        $js = str_replace('var component =', '', $js);

        return PHP_EOL . sprintf("vueComponents['%s'] = %s;", $this->getTemplateName($component), $js) . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getHtmlContent()
    {
        return $this->htmlContent;
    }

    /**
     * @return string
     */
    public function getJsContent()
    {
        return $this->jsContent;
    }
}
