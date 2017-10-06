<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Entry;

use SuperV\Modules\Supreme\Domains\Server\Model\AccountModel;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Platform\Domains\Entry\EntryModel;

class ServerEntryModel extends EntryModel
{
    public static $routeKeyname = 'server';

    protected $modelSlug = 'server';

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

    private function make_model()
    {
        return [
            'domain'    => 'supreme.server.model',
            'slug'      => 'server', // table auto? supreme_servers
            'model'     => 'ServerModel',
            'fields'    => [
                'name*',
                'slug*',
                'ip*',
                'port*'        => [
                    'type' => 'number',
                ],
                'distribution' => [
                    'type'    => 'select',
                    'options' => [
                        'debian_9' => 'Debian 9',
                        'debian_8' => 'Debian 8',
                        'centos_7' => 'Centos 7',
                        'centos_6' => 'Centos 6',
                    ],
                ],
            ],
            'relations' => [
                'account'  => [
                    'type'  => 'belongs_to',
                    'model' => AccountModel::class,
                ],
                'services' => [
                    'type'        => 'has_many',
                    'model'       => ServiceModel::class,
                    'foreign_key' => 'server_id' // auto?
                ],
            ],
        ];
    }

}