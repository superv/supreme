<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\Eloquent\ServerModel;
use SuperV\Platform\Domains\Droplet\Model\DropletModel;
use SuperV\Platform\Domains\Model\EloquentModel;

class ServiceModel extends EloquentModel
{
    protected $table = 'supreme_services';

    public function agent()
    {
        return $this->hasOne(DropletModel::class, 'id', 'agent_id');
    }

    /** @return DropletModel */
    public function getAgent()
    {
        return $this->agent;
    }

    public function server()
    {
        return $this->hasOne(\SuperV\Modules\Supreme\Domains\Server\Model\Eloquent\ServerModel::class, 'id', 'server_id');
    }

    /** @return ServerModel */
    public function getServer()
    {
        return $this->server;
    }
}