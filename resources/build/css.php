<?php

require_once dirname(__FILE__, 3) . '/vendor/autoload.php';

\ModulesGarden\PlanetHoster\Core\ModuleConstants::initialize();

$files = [
    'material-design-iconic-font.min.css',
    'products-icons.css',
    'simplemde.min.css',
    'layers2-ui.css',
    'module_styles.css',
    'mg_styles.css',
];

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'module')
{
    $files[] = 'module_main_content.css';
}

header('Content-Type: text/css');

foreach ($files as $file)
{
    $override = \ModulesGarden\PlanetHoster\Core\ModuleConstants::getFullPath('overrides', 'assets', 'css', $file);
    if (file_exists($override))
    {
        echo "@import \"../../overrides/assets/css/$file\";\n";
    }
    else
    {
        echo "@import \"../assets/css/$file\";\n";
    }
}

