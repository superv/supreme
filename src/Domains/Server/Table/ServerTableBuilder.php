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
        'edit'   => [
            'text' => 'Edit',
            'type' => 'info',
        ],
    ];
}