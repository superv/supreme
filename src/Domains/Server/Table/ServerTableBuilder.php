<?php namespace SuperV\Modules\Supreme\Domains\Server\Table;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Platform\Domains\UI\Table\TableBuilder;

class ServerTableBuilder extends TableBuilder
{
    protected $model = ServerModel::class;

    protected $columns = [
        'id',
        'name',
        'ip'
    ];

    protected $buttons = [
        'edit',
        'install' => [
            'text' => 'Install Service',
            'type' => 'success',
            'href' => 'supreme/services/1/install'
        ]
    ];
}