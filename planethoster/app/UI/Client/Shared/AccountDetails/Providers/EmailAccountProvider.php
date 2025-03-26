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

class EmailAccountProvider extends CrudProvider
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
                      $api->deleteEmailAccount($account_id, $serviceDetails['service']['domain'], $user[0]);
                  }
              }

             return (new Response())->setSuccess($this->translate('successAccountsEmailDeleted'))->setActions([new ReloadParent()]);


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
            return (new Response())->setError($this->translate('errorAccountId'))->setActions([new ReloadParent()]);
        }

        Validator::validate($this->formData->toArray(), [

            'username'      => [
                'sometimes',
                function(string $attribute, $value, Closure $fail) {
                    if(!ctype_alnum($value) || strlen($value) > 40){
                        $fail($this->translate('errorUsername'));
                    }
                }],

            'quota'      => [
                'required_if:quotaUnlim,off',
                function(string $attribute, $value, Closure $fail) use ($serviceDetails) {
                    if ($value < 0 || $value > $serviceDetails['productconfig']['email_quota'])
                    {
                        $fail(sprintf($this->translate('errorQuota'), $serviceDetails['productconfig']['email_quota']));
                    }
                }],
        ]);

        try {

            $api = new PlanetHosterAPI(
                $serviceDetails['server']['hostname'],
                $serviceDetails['server']['username'],
                $serviceDetails['server']['password'],
                $serviceDetails['server']['prefix']
            );

            $countEmail = $api->getEmailAccounts($account_id, true);
            if($countEmail >= $serviceDetails['productconfig']['max_email_account'])
            {
                return (new Response())->setError($this->translate('errorCountAccount'))->setActions([new ReloadParent()]);
            }

            $api->createEmailAccount([
                'id' => $account_id,
                'domain' => $serviceDetails['service']['domain'],
                'password' => $requestData['password'],
                'mailUser' => $requestData['username'],
                'quota' => $requestData['quota']
            ]);

            return (new Response())->setSuccess($this->translate('successAccountEmailCreate'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'email', $requestData['username']));

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
            return (new Response())->setError($this->translate('errorAccountId'))->setActions([new ReloadParent()]);
        }

        Validator::validate($this->formData->toArray(), [
            'quota'      => [
                'required_if:quotaUnlim,off',
                function(string $attribute, $value, Closure $fail) use ($serviceDetails) {
                    if ($value < 0 || $value > $serviceDetails['productconfig']['email_quota'])
                    {
                        $fail(sprintf($this->translate('errorQuota'), $serviceDetails['productconfig']['email_quota']));
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

            if(isset($requestData['value']) && !empty($requestData['value']))
            {
                if($requestData['value'] == 'false')
                {
                    $api->suspendEmailAccount($account_id, $requestData['name']);
                }
                else
                {
                    $api->unsuspendEmailAccount($account_id, $requestData['name']);
                }
            }
            else
            {
                $dataToUpdate = [
                    'id' => $account_id,
                    'domain' => $serviceDetails['service']['domain'],
                    'password' => $requestData['password'],
                    'mailUser' => $requestData['email'],
                    'quota' => $requestData['quota']
                ];

                if (empty($requestData['password'])) {
                    unset($dataToUpdate['password']);
                }

                if (empty($requestData['quota'])) {
                    unset($dataToUpdate['quota']);
                }

                $api->updateEmailAccount($dataToUpdate);
            }

            return (new Response())->setSuccess($this->translate('successAccountEmailUpdate'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'email', $requestData['email']));

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

            $api->deleteEmailAccount($account_id, $serviceDetails['service']['domain'], $requestData['email']);

            return (new Response())->setSuccess($this->translate('successAccountEmailDeleted'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

        }

    }

    public function getData()
    {
        return $this->data;
    }

}
