<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Entry;

use SuperV\Modules\Supreme\Domains\Server\Model\AccountModel;
use SuperV\Platform\Domains\Entry\EntryModel;

class ServerEntryModel extends EntryModel
{
    public static $routeKeyname = 'server';

    protected $table = 'supreme_servers';

    protected $relationships = ['account'];

    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'ip:text|required',
        'port:integer|max:100',
        'account:relation|required'    => [
            'related'  => AccountModel::class,
            'multiple' => false,
            'expanded' => false,
        ],
        'distribution:choice|required' => [
            'choices' => [
                'Debian 9' => 'debian_9',
                'Debian 8' => 'debian_8',
                'Centos 7' => 'centos_7',
                'Centos 6' => 'centos_6',
            ],
        ],
    ];
}