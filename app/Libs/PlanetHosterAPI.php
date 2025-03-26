<?php

namespace ModulesGarden\PlanetHoster\App\Libs;

class PlanetHosterAPI
{
    protected $host;
    protected $apiUser;
    protected $apiKey;
    protected $apiVersion;

    protected $httpprefix;

    public function __construct($host, $apiUser, $apiKey, $httpprefix = 'https')
    {
        $this->host = $host;
        $this->apiUser = $apiUser;
        $this->apiKey = $apiKey;
        $this->apiVersion = 'v3';
        $this->httpprefix = $httpprefix;
    }

    public function hello()
    {
        return $this->send('GET', 'hello');
    }

    public function accountInfo()
    {
        return $this->send('GET', 'account/info');
    }

    public function theWorldInfo()
    {
        return $this->send('GET', 'the-world/info');
    }

    public function getInfoAccount($account_id)
    {
        $results = $this->send('GET', 'the-world/info');
        foreach ($results['world_accounts'] as $row) {
          if($row['id'] == $account_id)
          {
            return $row;
          }
        }
        throw new \Exception('The account does not exist.');
    }

    public function createAccount($params)
    {
        return $this->send('POST', 'hosting', $params);
    }

    public function terminatedAccount($id, $username, $password)
    {
        $params = ['id' => $id, 'username' => $username, 'password' => $password];
        return $this->send('DELETE', 'hosting', $params);
    }

    public function suspendAccount($id, $username, $reason)
    {
        $params = ['id' => $id, 'username' => $username, 'reason' => $reason];
        return $this->send('POST', 'hosting/suspend', $params);
    }

    public function unsuspendAccount($id, $username)
    {
        $params = ['id' => $id, 'username' => $username];
        return $this->send('POST', 'hosting/unsuspend', $params);
    }

    public function updateAccount($params)
    {
        return $this->send('PUT', 'hosting', $params);
    }

    public function createEmailAccount($params)
    {
        return $this->send('POST', 'hosting/email', $params);
    }

    public function createFTPAccount($params)
    {
        return $this->send('POST', 'hosting/ftp', $params);
    }

    public function loginPhpMyAdmin($id, $username)
    {
        return $this->send('GET', 'hosting/databases/phpmyadmin', [
            'id' => $id,
            'username' => $username
        ]);
    }

    public function createDatabase($params)
    {
        return $this->send('POST', 'hosting/database', $params);
    }

    public function createUserDatabase($params)
    {
        return $this->send('POST', 'hosting/database/user', $params);
    }

    public function updateUserDatabase($params)
    {
        return $this->send('PATCH', 'hosting/database/user', $params);
    }

    public function setPrivileges($params)
    {
        return $this->send('PUT', 'hosting/database/user/privileges', $params);
    }

    public function removePrivileges($params)
    {
        return $this->send('DELETE', 'hosting/database/user/privileges', $params);
    }

    public function updateFTPAccount($params)
    {
        return $this->send('PATCH', 'hosting/ftp', $params);
    }

    public function updateEmailAccount($params)
    {
        return $this->send('PATCH', 'hosting/email', $params);
    }

    public function suspendEmailAccount($id, $email)
    {
        return $this->send('POST', 'hosting/email/suspend', ['email' => $email, 'id' => $id]);
    }

    public function unsuspendEmailAccount($id, $email)
    {
        return $this->send('POST', 'hosting/email/unsuspend', ['email' => $email, 'id' => $id]);
    }

    public function getEmailAccounts($id, $count = false)
    {
        $results = [];

        $response = $this->send('GET', 'hosting/emails', ['id' => $id]);

        if($count === true)
        {
            return count($response['data']);
        }

        foreach ($response['data'] as $row)
        {
            $status = '';
            if($row['status'] == 'ACTIVE')
            {
                $status = '1';
            }

            $results[] = [
                'id' => base64_encode(json_encode(['user' => $row['email']])),
                'name' => $row['email'],
                'email' => $row['account'],
                'quota' => $row['quota'],
                'status' => $status,
            ];
        }
        return $results;
    }

    public function getFtpAccounts($id, $count = false)
    {
        $results = [];

        $response = $this->send('GET', 'hosting/ftp', ['id' => $id]);
        if($count === true)
        {
            return count($response['data']);
        }

        foreach ($response['data'] as $item)
        {
            $results[] = [
                'id' => base64_encode(json_encode(['user' => $item['username']])),
                'username' => $item['username'],
                'path' => $item['path']
            ];
        }

        return $results;
    }

    public function getUserByDatabase($id, $dbname)
    {
        $response = $this->send('GET', 'hosting/databases', ['id' => $id]);
        foreach($response['data'] as $db)
        {
            if($db['name'] == $dbname)
            {
                return reset($db['databaseUsers']);
            }
        }
        return false;
    }


    public function getDatabases($id, $count = false)
    {
        $results = [];

        $response = $this->send('GET', 'hosting/databases', ['id' => $id]);
        if($count === true)
        {
            return count($response['data']);
        }

        foreach ($response['data'] as $item)
        {
            $user = reset($item['databaseUsers']);
            $results[] = [
                'id' => base64_encode(json_encode(['db' => $item['name']])),
                'database' => $item['name'],
                'username' => is_array($user) ? $user['name'] : null,
                'permissions' => is_array($user) ? explode(',',$user['permissions']) : null,
            ];
        }

        return $results;
    }

    public function deleteEmailAccount($id, $domain, $user)
    {
        return $this->send('DELETE', 'hosting/email', ['id' => $id, 'domain' => $domain, 'mailUser' => $user]);
    }

    public function deleteFTPAccount($id, $domain, $user)
    {
        return $this->send('DELETE', 'hosting/ftp', ['id' => $id, 'domain' => $domain, 'ftpUser' => $user]);
    }

    public function deleteDatabase($params)
    {
        return $this->send('DELETE', 'hosting/database', $params);
    }

    public function deleteDatabaseUser($params)
    {
        return $this->send('DELETE', 'hosting/database/user', $params);
    }

    public function getStatsResource($account_id, $username, $period = 24)
    {
        $type = 'day';
        if($period == 24 || $period == 48)
        {
            $type = 'hour';
        }
        return $this->send('GET', 'hosting/stats/performance', ['id' => $account_id, 'username' => $username, 'periodType' => $type, 'period' => $period]);
    }

    public function getStatsDisk($account_id, $username)
    {
        return $this->send('GET', 'hosting/stats/disk-usage', ['id' => $account_id, 'username' => $username]);
    }

    public function getStatsVisitors($account_id, $domain, $period = '30d')
    {
        return $this->send('GET', 'hosting/stats/apache', ['id' => $account_id, 'domain' => $domain, 'period' => $period]);
    }

    protected function send($method, $action, $data = [])
    {
        if (!empty($data)) {
            $query = http_build_query($data);
        } else {
            $query = null;
        }

        $curl = curl_init();

        $headers = [];
        $headers[] = 'X-API-USER: ' . $this->apiUser;
        $headers[] = 'X-API-KEY: ' . $this->apiKey;
        $headers[] = 'accept: application/json';
        $url = $this->httpprefix.'://'.$this->host.'/'.$this->apiVersion.'/'.$action;

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        if (in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']) && strlen($query) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_info = curl_getinfo($curl);
        $result = substr($response, $curl_info['header_size']);

        logModuleCall('planethoster', $action, str_replace([$this->apiUser, $this->apiKey], '***************', $curl_info['request_header'] . $query), str_replace([$this->apiUser, $this->apiKey], '***************', $response));

        if (curl_errno($curl) > 0) {
            throw new \Exception('connectionError');
        }

        $data = json_decode($result, true);

        if (!is_array($data)) {
            throw new \Exception('invalidJSON');
        }

        if (isset($data['error']) && !empty($data['error'])) {
            throw new \Exception('unexpectedError');
        }

        if (isset($data['errors']) && !empty($data['errors'])) {
            if(in_array('isStrongPassword', $data['errors']))
            {
              throw new \Exception('errorPassword');
            }
            
            if(is_array($data['errors']) && !empty($data['errors']))
            {
                foreach ($data['errors'] as $errorRow)
                {
                    if(is_array($errorRow))
                    {
                        $errorRow = reset($errorRow);
                    }
                    if(isset($errorRow['message']) && $errorRow['message'] == 'isStrongPassword')
                    {
                        throw new \Exception('errorPassword');
                    }
                    
                    if(strpos($errorRow, 'beta to use PostgreSQL') !== false)
                    {
                        throw new \Exception('betaPostgreSQL');
                    }
                    
                    if(strpos($errorRow, 'database user') !== false && strpos($errorRow, 'already exist') !== false)
                    {
                        throw new \Exception('alreadyExistsDatabaseUser');
                    }
                    
                    if($action == 'hosting/database' && strpos($errorRow, 'already exist') !== false)
                    {
                        throw new \Exception('alreadyExistsDatabase');
                    }
                    
                    if($errorRow == 'ER_CANNOT_USER' && $action == 'hosting/database/user')
                    {
                        throw new \Exception('alreadyExistsDatabaseUser');
                    }
                    
                    if(strpos($errorRow, 'already exist') !== false)
                    {
                        throw new \Exception('alreadyExists');
                    }
                }
            }
            
            throw new \Exception('unexpectedError');
        }

        if(isset($data['success']) && $data['success'] === false)
        {
            if(!empty($data['errors']))
            {
                throw new \Exception('unexpectedError');
            }
            else
            {
                throw new \Exception('unexpectedError');
            }
        }

        curl_close($curl);

        return $data;
    }
}
