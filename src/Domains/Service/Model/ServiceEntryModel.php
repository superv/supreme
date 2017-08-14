<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Platform\Domains\Droplet\Model\DropletModel;
use SuperV\Platform\Domains\Entry\EntryModel;

class ServiceEntryModel extends EntryModel
{
    protected $table = 'supreme_services';

    protected $fields = [
        'name:text|required',
        'slug:text|required|unique',
        'type:text|required',
        'server:relation|required' => [
            'related'  => ServerModel::class,
            'multiple' => false,
        ],
        'agent:relation|required'  => [
            'related'  => DropletModel::class,
            'multiple' => false,
        ],
    ];

    protected $relationships = ['server', 'agent'];
//
//    public function getAttribute($key)
//    {
//        parent::getAttribute($key);
//    }
}