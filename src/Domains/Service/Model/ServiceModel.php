<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Nucleus\Domains\Entry\Nucleus;
use SuperV\Platform\Domains\Droplet\Model\DropletModel;

class ServiceModel extends Nucleus
{
    protected $table = 'supreme_services';

    public function agentxx()
    {
        return $this->hasOne(DropletModel::class, 'id', 'agent_id');
    }

    /** @return DropletModel */
    public function getAgent()
    {
        return $this->agent;
    }

    public function serverxxxx()
    {
        return $this->hasOne(\SuperV\Modules\Supreme\Domains\Server\Model\ServerModel::class, 'id', 'server_id');
    }

    /** @return ServerModel */
    public function getServer()
    {
        return $this->server;
    }
}