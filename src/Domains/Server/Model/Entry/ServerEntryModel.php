<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Entry;

use SuperV\Platform\Domains\Entry\EntryModel;

class ServerEntryModel extends EntryModel
{
    protected $table = 'supreme_servers';

    protected $relationships = ['account'];

    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'ip:text|required',
        'port:integer|max:100',
        'account:relation|required' => [
            'related'  => 'SuperV\Modules\Supreme\Domains\Server\Model\AccountModel',
            'multiple' => false,
            'expanded' => false,
        ],
    ];
}