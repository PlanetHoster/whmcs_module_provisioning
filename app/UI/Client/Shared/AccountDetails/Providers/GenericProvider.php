<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers;

use Closure;
use GuzzleHttp\RedirectMiddleware;
use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\Core\Components\Actions\Redirect;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\DataProviders\CrudProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\Components\Response\Response;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ReloadParent;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Validator;
use function ModulesGarden\PlanetHoster\Core\Helper\redirect;

class GenericProvider extends CrudProvider
{
    use TranslatorTrait;

    // public function phpMyAdmin()
    // {
    //     $serviceId = Request::get('id');
    //     $requestData = Request::get('formData');
    //     $serviceRepo = new ServicesRepository();
    //     $serviceDetails = $serviceRepo->getServicesData($serviceId);
    //     $account_id = $serviceDetails['customfields']['account_id'];

    //     if(empty($account_id))
    //     {
    //         return (new Response())->setError($this->translate('errorAccountId'));
    //     }

    //     try {

    //         $api = new PlanetHosterAPI(
    //             $serviceDetails['server']['hostname'],
    //             $serviceDetails['server']['username'],
    //             $serviceDetails['server']['password'],
    //             $serviceDetails['server']['prefix']
    //         );

    //         $formData = $this->formData->all();
    //         $userDB = $api->getUserByDatabase($account_id, $requestData['database']);
    //         $phpMyAdmin = $api->loginPhpMyAdmin($account_id, $userDB);

    //         return (new Response())->setSuccess($this->translate('successAccountsDatabasePhmMyAdmin'))->setActions([new Redirect($phpMyAdmin['data']['loginUrl'])]);


    //     } catch (\Exception $e) {

    //         return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

    //     }
    // }
    public function removeTemporaryUrl()
    {
        $serviceId = Request::get('id');
        $requestData = Request::get('formData');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];

        if(empty($account_id))
        {
            return (new Response())->setError($this->translate('errorAccountId'));
        }

        try {

            $api = new PlanetHosterAPI(
                $serviceDetails['server']['hostname'],
                $serviceDetails['server']['username'],
                $serviceDetails['server']['password'],
                $serviceDetails['server']['prefix']
            );

            $api->removeTemporaryUrl([
                'id' => $account_id,
            ]);

            return (new Response())->setActions([new ReloadParent()]);

        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']), '', ''));

        }
    }
    public function createTemporaryUrl()
    {
        $serviceId = Request::get('id');
        $requestData = Request::get('formData');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);
        $account_id = $serviceDetails['customfields']['account_id'];

        if(empty($account_id))
        {
            return (new Response())->setError($this->translate('errorAccountId'));
        }

        try {

            $api = new PlanetHosterAPI(
                $serviceDetails['server']['hostname'],
                $serviceDetails['server']['username'],
                $serviceDetails['server']['password'],
                $serviceDetails['server']['prefix']
            );

            $api->createTemporaryUrl([
                'id' => $account_id,
            ]);

            return (new Response())->setActions([new ReloadParent()]);

        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']), '', ''));

        }
        }
    }


    public function getData()
    {
        return $this->data;
    }

}
