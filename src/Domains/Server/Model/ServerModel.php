<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Platform\Domains\Model\EloquentModel;

class ServerModel extends EloquentModel
{
    protected $table = 'supreme_servers';

    public function account()
    {
        return $this->belongsTo(AccountModel::class, 'account_id');
    }

    public function services()
    {
        return $this->belongsToMany(ServiceModel::class, 'supreme_server_services', 'server_id', 'services_id');
    }

}