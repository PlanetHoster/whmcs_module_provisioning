<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Providers;

use Closure;
use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\Core\Components\Traits\TranslatorTrait;
use ModulesGarden\PlanetHoster\Core\DataProviders\CrudProvider;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\Components\Response\Response;
use ModulesGarden\PlanetHoster\Core\Components\Actions\ReloadParent;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Validator;

class FtpAccountsProvider extends CrudProvider
{
    use TranslatorTrait;
    
    public const ACTION_MASS_DELETE     = 'deleteMass';
    
    public function deleteMass()
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


            $formData = $this->formData->all();

            if ($formData['id'])
            {
                $users = explode(',', $formData['id']);
                foreach ($users as $user)
                {
                    $decodedUser = json_decode(base64_decode($user));
                    $user = explode('@',  $decodedUser->user);
                    $api->deleteFTPAccount($account_id, $serviceDetails['service']['domain'], reset($user));
                }
            }

             return (new Response())->setSuccess($this->translate('successAccountsFtpDeleted'))->setActions([new ReloadParent()]);


         } catch (\Exception $e) {

             return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

         }

    }

    public function create()
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

        Validator::validate($this->formData->toArray(), [
            'user' => [
                'sometimes',
                function(string $attribute, $value, Closure $fail) {
                    if(!ctype_alnum($value) || strlen($value) > 40){
                        $fail($this->translate('errorUser'));
                    }
                }]
        ]);

        try {

            $api = new PlanetHosterAPI(
                $serviceDetails['server']['hostname'],
                $serviceDetails['server']['username'],
                $serviceDetails['server']['password'],
                $serviceDetails['server']['prefix']
            );

            $countFtp = $api->getFtpAccounts($account_id, true);
            if($countFtp >= $serviceDetails['productconfig']['max_ftp_account'])
            {
                return (new Response())->setError($this->translate('errorCountAccount'));
            }
            
            $paramsCreateFTP = [
                'id' => $account_id,
                'domain' => $serviceDetails['service']['domain'],
                'password' => $requestData['password'],
                'ftpUser' => $requestData['user'],
                'path' => $requestData['path']
            ];

            if(empty($requestData['path']))
            {
                $paramsCreateFTP['path'] = '/';
            }

            if($requestData['path'] != '/')
            {
                $paramsCreateFTP['createFolder'] = 'true';
            }

            $api->createFTPAccount($paramsCreateFTP);

            return (new Response())->setSuccess($this->translate('successFtpAccountCreate'))->setActions([new ReloadParent()]);
                
            
        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'FTP', $requestData['user']));

        }
    }

    public function update()
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

            $user = explode('@', $requestData['username']);

            $dataToUpdate = [
                'id' => $account_id,
                'domain' => $serviceDetails['service']['domain'],
                'password' => $requestData['password'],
                'ftpUser' => reset($user),
                'path' => $requestData['path']
            ];

            if (empty($requestData['password'])) {
                unset($dataToUpdate['password']);
            }

            if (empty($requestData['path'])) {
                unset($dataToUpdate['path']);
            }

            if(!empty($requestData['path']) && $requestData['path'] != '/')
            {
                $dataToUpdate['createFolder'] = 'true';
            }
            
            $api->updateFTPAccount($dataToUpdate);

            return (new Response())->setSuccess($this->translate('successAccountUpdate'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'FTP', ''));

        }

    }


    public function delete()
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
            $user = explode('@', $requestData['username']);
            $api->deleteFTPAccount($account_id, $serviceDetails['service']['domain'], reset($user));

            return (new Response())->setSuccess($this->translate('successDeleted'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

        }

    }

    public function getData()
    {
        return $this->data;
    }

}
