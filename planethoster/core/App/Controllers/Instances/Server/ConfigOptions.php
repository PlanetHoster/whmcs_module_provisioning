<?php

namespace ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Server;

use ModulesGarden\PlanetHoster\Components\Alert\AlertDanger;
use ModulesGarden\PlanetHoster\Components\PreBlock\PreBlock;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\AddonController;
use ModulesGarden\PlanetHoster\Core\App\Controllers\Instances\Http\ConfigOptionsIntegration;
use ModulesGarden\PlanetHoster\Core\Events\Events\ConfigOptionsLoaded;
use ModulesGarden\PlanetHoster\Core\Helper\BuildUrl;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\UI\ViewConfigOptions;
use function ModulesGarden\PlanetHoster\Core\fire;

abstract class ConfigOptions extends AddonController
{
    public function runExecuteProcess($params = null)
    {
        fire(ConfigOptionsLoaded::class);

        if (!\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::get('loadProductConfiguration', false))
        {
            return [
                'loading' => [
                    'Type'        => '',
                    'Description' => $this->getJsCode(),
                ],
            ];
        }

        try
        {
            return parent::runExecuteProcess($params);
        }
        catch (\Throwable $t)
        {
            //@todo UI should be build in different class
            $alert = new AlertDanger();
            $alert->setText($t->getMessage());

            $pre = new PreBlock();
            $pre->setContent($t->getTraceAsString());

            $view = new ViewConfigOptions();
            $view->addElement($alert);
            $view->addElement($pre);

            return (new ConfigOptionsIntegration)->runExecuteProcess($view);
        }
    }

    /**
     * @return string
     * @todo migrate it
     */
    private function getJsCode()
    {
        $dataQuery   = http_build_query(\ModulesGarden\PlanetHoster\Core\Support\Facades\Request::getFacadeRoot()->request->all());
        $serverGroup = (int)Request::get('servergroup', 0);
        $fullUrl     = BuildUrl::fullUrl();

        //@todo refactor me
        return "
                <script>
                    $('#layers2').remove();
                    $('.lu-alert').remove();
                    $('#tblModuleSettings').addClass('hidden');
                    $('#tblMetricSettings').before('<img style=\"margin-left: 50%; margin-top: 15px; margin-bottom: 15px; height: 20px\" id=\"mg-configoptionLoader\" src=\"images/loading.gif\">');
                    
                    $.post({
                        url: '$fullUrl?$dataQuery&loadProductConfiguration=1'
                    })
                    .done(function( data ){
                        let json = JSON.parse(data);
        
                        $('#mg-configoptionLoader').remove();
                        $('#tblModuleSettings').html(json.content).removeClass('hidden');
                    });
                </script>";
    }
}
