<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Entry\EntryModel;

class ServerEntryModel extends EntryModel
{
    protected $table = 'supreme_servers';

    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'ip:text|required',
        'port:integer'              => ['default' => 22],
        'account:relation|required' => [
            'related' => 'SuperV\Modules\Supreme\Domains\Server\Model\AccountModel',
        ],
    ];
}