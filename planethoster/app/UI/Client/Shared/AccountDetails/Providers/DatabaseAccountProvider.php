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

class DatabaseAccountProvider extends CrudProvider
{
    use TranslatorTrait;
    
    public const ACTION_MASS_DELETE     = 'deleteMass';
    public const PHP_MY_ADMIN     = 'phpMyAdmin';

    public function phpMyAdmin()
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
            $userDB = $api->getUserByDatabase($account_id, $requestData['database']);
            $phpMyAdmin = $api->loginPhpMyAdmin($account_id, $userDB);

            return (new Response())->setSuccess($this->translate('successAccountsDatabasePhmMyAdmin'))->setActions([new Redirect($phpMyAdmin['data']['loginUrl'])]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

        }
    }
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
                $rows = explode(',', $formData['id']);
                foreach ($rows as $row)
                {
                    $decodedRow = json_decode(base64_decode($row));
                    $db = $decodedRow->db;
                    
                    $userDB = $api->getUserByDatabase($account_id, $db);
                    if(is_array($userDB) && !empty($userDB['name']))
                    {
                        $api->deleteDatabaseUser([
                            'id' => $account_id,
                            'dbUser' => is_array($userDB) ? $userDB['name'] : null,
                        ]);
                    }
                    $api->deleteDatabase([
                        'id' => $account_id,
                        'name' => $db
                    ]);
                   
                }
            }

             return (new Response())->setSuccess($this->translate('successAccountsDatabaseDeleted'))->setActions([new ReloadParent()]);


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

        $dbCreated = false;

        if(empty($account_id))
        {
            return (new Response())->setError($this->translate('errorAccountId'));
        }

        Validator::validate($this->formData->toArray(), [
            'database'      => [
                'sometimes',
                function(string $attribute, $value, Closure $fail) {
                    if(!ctype_alnum($value) || strlen($value) > 40){
                        $fail($this->translate('errorDatabase'));
                    }
                }],

            'username'      => [
                'sometimes',
                function(string $attribute, $value, Closure $fail) {
                    if(!ctype_alnum($value) || strlen($value) > 40){
                        $fail($this->translate('errorUsername'));
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

            $countDB = $api->getDatabases($account_id, true);
            if($countDB >= $serviceDetails['productconfig']['max_user_db'])
            {
                return (new Response())->setError($this->translate('errorCountAccount'));
            }

            $api->createDatabase([
                'id' => $account_id,
                'name' => $requestData['database'],
                'databaseType' => $requestData['type']
            ]);


            $dbCreated = true;

            $api->createUserDatabase([
                'id' => $account_id,
                'dbUser' => $requestData['username'],
                'password' => $requestData['password'],
                'databaseType' => $requestData['type']
            ]);
            
            if(in_array('ALL PRIVILEGES', $requestData['privileges'])) $requestData['privileges'] = ['ALL PRIVILEGES'];

            $api->setPrivileges([
                'id' => $account_id,
                'databaseName' => $requestData['database'],
                'databaseUsername' => $requestData['username'],
                'privileges' => $requestData['privileges']
            ]);

            return (new Response())->setSuccess($this->translate('successDatabaseCreate'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            if($dbCreated === true) {
                try {

                    $api = new PlanetHosterAPI(
                        $serviceDetails['server']['hostname'],
                        $serviceDetails['server']['username'],
                        $serviceDetails['server']['password'],
                        $serviceDetails['server']['prefix']
                    );

                    $api->deleteDatabase([
                        'id' => $account_id,
                        'name' => $requestData['database']
                    ]);


                } catch (\Exception $e) {
                }
                
                $requestData['database'] = $requestData['username'];
                
            }

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']), $requestData['database']));

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

        Validator::validate($this->formData->toArray(), [
            'username_new'      => [
                'sometimes',
                function(string $attribute, $value, Closure $fail) {
                    if(!ctype_alnum($value) || strlen($value) > 40){
                        $fail($this->translate('errorUsername'));
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

            if(in_array('ALL PRIVILEGES', $requestData['permissions'])) $requestData['permissions'] = ['ALL PRIVILEGES'];
            
            $userDB = $api->getUserByDatabase($account_id, $requestData['database']);

            if(is_array($userDB) && !empty($userDB['name']))
            {
                $api->removePrivileges([
                    'id' => $account_id,
                    'databaseName' => $requestData['database'],
                    'databaseUsername' => is_array($userDB) ? $userDB['name'] : null,
                    'privileges' => is_array($userDB) ? explode(',',$userDB['permissions']) : null,
                ]);

                $api->setPrivileges([
                    'id' => $account_id,
                    'databaseName' => $requestData['database'],
                    'databaseUsername' => is_array($userDB) ? $userDB['name'] : null,
                    'privileges' => $requestData['permissions']
                ]);

                $toUpdate = [
                    'id' => $account_id,
                    'databaseUsername' => is_array($userDB) ? $userDB['name'] : null,
                    'newDatabaseUsername' => $requestData['username_new'],
                    'newPassword' => $requestData['password']
                ];

                if($toUpdate['newDatabaseUsername'] == $toUpdate['databaseUsername'])
                {
                    unset($toUpdate['newDatabaseUsername']);
                }

                if(empty($requestData['password']))
                {
                    unset($toUpdate['newPassword']);
                }

                if(isset($toUpdate['newPassword']) || isset($toUpdate['newDatabaseUsername']))
                {
                    $api->updateUserDatabase($toUpdate);
                }
            }
            
            return (new Response())->setSuccess($this->translate('successDatabaseUpdate'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']), $requestData['username_new']));

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

            $userDB = $api->getUserByDatabase($account_id, $requestData['database']);

            if(is_array($userDB) && !empty($userDB['name']))
            {
                $api->deleteDatabaseUser([
                    'id' => $account_id,
                    'dbUser' => is_array($userDB) ? $userDB['name'] : null,
                ]);
            }
            
            $api->deleteDatabase([
                'id' => $account_id,
                'name' => $requestData['database']
            ]);

            return (new Response())->setSuccess($this->translate('successDatabaseDeleted'))->setActions([new ReloadParent()]);


        } catch (\Exception $e) {

            return (new Response())->setError(sprintf($this->translate($e->getMessage(), [], ['global']),'', ''));

        }

    }

    public function getData()
    {
        return $this->data;
    }

}
