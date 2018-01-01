<?php namespace SuperV\Modules\Supreme\Model\Entry;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Platform\Domains\Droplet\Droplet;
use SuperV\Platform\Domains\Entry\EntryModel;

class ServiceEntryModel extends EntryModel
{
    public static $routeKeyname = 'service';

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
            'related'  => Droplet::class,
            'multiple' => false,
        ],
    ];

    protected $relationships = ['server', 'agent'];
}