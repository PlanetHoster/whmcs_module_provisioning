<?php

namespace ModulesGarden\PlanetHoster\App\UI\Client\Shared\AccountDetails\Pages;

use ModulesGarden\PlanetHoster\Components\Container\Container;
use ModulesGarden\PlanetHoster\Components\TableSimple\Record\Record;
use ModulesGarden\PlanetHoster\Components\TableSimple\TableSimple;
use ModulesGarden\PlanetHoster\Components\TextShowHide\TextShowHide;
use ModulesGarden\PlanetHoster\Components\Widget\Widget;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\ClientAreaInterface;
use ModulesGarden\PlanetHoster\Core\Contracts\Components\AjaxComponentInterface;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\App\Repositories\ServicesRepository;
use ModulesGarden\PlanetHoster\App\Libs\PlanetHosterAPI;

class Details extends Container implements AjaxComponentInterface, ClientAreaInterface
{
    public function loadHtml(): void
    {
        $serviceId = Request::get('id');
        $serviceRepo = new ServicesRepository();
        $serviceDetails = $serviceRepo->getServicesData($serviceId);

        $status = '<span class="label label-default">' . $this->translate('none') . '</span>';

        if(!empty($serviceDetails)) {

          $account_id = $serviceDetails['customfields']['account_id'];

          try {

              if(!empty($account_id)) {

                  $api = new PlanetHosterAPI(
                      $serviceDetails['server']['hostname'],
                      $serviceDetails['server']['username'],
                      $serviceDetails['server']['password'],
                      $serviceDetails['server']['prefix']
                  );
                  $results = $api->getInfoAccount($account_id);

                  if (!empty($results['hosting_accounts'][0])) {
                      $account = $results['hosting_accounts'][0];
                      $serviceDetails['service']['domain'] = $account['domain'];
                      $serviceDetails['service']['username'] = $account['username'];
                      $serviceDetails['service']['dedicatedip'] = $account['ip'];
                      $serviceDetails['productconfig']['country'] = strtoupper($account['location']);
                      $serviceDetails['productconfig']['cpu'] = $account['resources']['cpu'];
                      $serviceDetails['productconfig']['memory'] = $account['resources']['mem'];
                      $serviceDetails['productconfig']['io'] = $account['resources']['io'];

                      // Litespeed
                      $serviceDetails['productconfig']['ls'] = $account['litespeed'] ? '1' : '0';

                      // CMS name (exemple, à adapter si besoin)
                      $serviceDetails['productconfig']['cms_name'] = !empty($account['cms_name']) ? $account['cms_name'] : 'none';

                      // Temporary URL
                      $serviceDetails['service']['temporary_url'] =  !empty($account['temporary_url']) ? $account['temporary_url'] : 'none';

                      // Status
                      if ($account['status'] == 'Active' || $account['status'] == 'active') {
                          $status = '<span class="label label-success">' . $account['status'] . '</span>';
                      } else {
                          $status = '<span class="label label-warning">' . $account['status'] . '</span>';
                      }
                  }
              }

          } catch (\Exception $e) {

              \logActivity('[ERROR PLANETHOSTER] '.$e->getMessage(), 0);

          }


            $ls = '<span class="label label-danger">' . $this->translate('disabled') . '</span>';
            if ($serviceDetails['productconfig']['ls'] == '1') {
                $ls = '<span class="label label-success">' . $this->translate('enabaled') . '</span>';
            }

            $cms = [
                'wp' => 'WordPress',
                'joomla' => 'Joomla',
                'prestashop' => 'Prestashop',
                'drupal' => 'Drupal'
            ];

            $cmsName = $cms[$serviceDetails['productconfig']['cms_name']];
            if(empty($cmsName))
            {
              $cmsName = $this->translate('none');
            }

            $widgetNew = new Widget();
            $widgetNew->setTitle($this->translate('details'));

            $tableNew = new TableSimple();

            $tableNew->addRecord(new Record([
                $this->translate('domain'),
                '<b>' . $serviceDetails['service']['domain'] . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('status'),
                '<b>' . $status . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('ip'),
                '<b>' . $serviceDetails['service']['dedicatedip'] . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('username'),
                '<b>' . $serviceDetails['service']['username'] . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('password'),
                (new TextShowHide())->setText($serviceDetails['service']['password']),
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('temporaryURL'),
                (new TextShowHide())->setText($serviceDetails['service']['temporary_url']),
            ]));

            // Ajout des boutons d'action pour l'URL temporaire
            $actions = '';
            if (empty($serviceDetails['service']['temporary_url']) || $serviceDetails['service']['temporary_url'] === 'none') {
                $actions = '<a href="index.php?mg-action=createTemporaryUrl&id=' . $serviceId . '" class="btn btn-primary">Créer une URL temporaire</a>';
            } else {
                $actions = '<a href="index.php?mg-action=deleteTemporaryUrl&id=' . $serviceId . '" class="btn btn-danger" onclick="return confirm(\'Confirmer la suppression de l\'URL temporaire ?\')">Supprimer l\'URL temporaire</a>';
            }
            $tableNew->addRecord(new Record([
                '',
                $actions
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('cpu'),
                '<b>' . $serviceDetails['productconfig']['cpu'] . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('memory'),
                '<b>' . $serviceDetails['productconfig']['memory'] . ' GB</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('i_o_bandwidth'),
                '<b>' . $serviceDetails['productconfig']['io'] . ' MB/s</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('litespeed'),
                '<b>' . $ls . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('cms'),
                '<b>' . $cmsName . '</b>',
            ]));

            $tableNew->addRecord(new Record([
                $this->translate('country'),
                '<b>' . $serviceDetails['productconfig']['country'] . '</b>',
            ]));


            $widgetNew->addElement($tableNew);
            $this->addElement($widgetNew);

        }

    }
}
