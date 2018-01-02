<?php

use SuperV\Modules\Supreme\Http\Controllers\AccountsController;

return [
    'supreme/accounts/index'          => [
        'as'   => 'supreme::accounts.index',
        'uses' => AccountsController::at('index'),
    ],
    'supreme/accounts/{account}/edit' => [
        'as'   => 'supreme::accounts.edit',
        'uses' => AccountsController::at('edit'),
    ],
    'supreme/accounts/create'         => [
        'as'   => 'supreme::accounts.create',
        'uses' => AccountsController::at('create'),
    ],
];
