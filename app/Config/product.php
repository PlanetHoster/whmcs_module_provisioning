<?php
// phpcs:ignoreFile

use ModulesGarden\PlanetHoster\Packages\Product\Libs\CustomFields\TextBox;
use ModulesGarden\PlanetHoster\Core\Support\Facades\Request;
use ModulesGarden\PlanetHoster\Core\WHMCS\URL;
use ModulesGarden\PlanetHoster\Core;

return [
    'sidebars'                  => [
        Core\translate('planetHoster') => [
            Core\translate('accountDetails') => [
                'order' => 1,
                'uri'   => function() {
                    return URL\Client::productDetails(Request::get('id', 0), ['mg-action' => 'index']);
                }
            ],
            Core\translate('emails') => [
                'order' => 2,
                'uri'   => function() {
                    return URL\Client::productDetails(Request::get('id', 0), ['mg-action' => 'emails']);
                }
            ],
            Core\translate('ftpaccounts') => [
                'order' => 3,
                'uri'   => function() {
                    return URL\Client::productDetails(Request::get('id', 0), ['mg-action' => 'ftpaccounts']);
                }
            ],
            Core\translate('databases') => [
                'order' => 4,
                'uri'   => function() {
                    return URL\Client::productDetails(Request::get('id', 0), ['mg-action' => 'databases']);
                }
            ],
            Core\translate('charts') => [
                'order' => 5,
                'uri'   => function() {
                    return URL\Client::productDetails(Request::get('id', 0), ['mg-action' => 'charts']);
                }
            ]
        ]
    ],
    'CustomFields'              => [
        (new TextBox('account_id', 'Account ID'))->setAdminOnly(),
    ],
    'ConfigurableOptions'       => [],
    'ConfigurableOptionsLoader' => function(int $productId) {
        return [];
    }
];