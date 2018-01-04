<?php

use SuperV\Modules\Supreme\Http\Controllers\ServersController;

return [
    'supreme/servers/index'          => [
        'as'   => 'supreme::servers.index',
        'uses' => ServersController::at('index'),
    ],
    'supreme/servers/{server}/edit' => [
        'as'   => 'supreme::servers.edit',
        'uses' => ServersController::at('edit'),
    ],
    'supreme/servers/create'         => [
        'as'   => 'supreme::servers.create',
        'uses' => ServersController::at('create'),
    ],
];
