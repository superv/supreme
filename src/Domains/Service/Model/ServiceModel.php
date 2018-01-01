<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Model\Entry\ServiceEntryModel;
use SuperV\Platform\Domains\Droplet\Droplet;

class ServiceModel extends ServiceEntryModel
{
    public function agent()
    {
        return $this->hasOne(Droplet::class, 'id', 'agent_id');
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    /** @return Droplet */
    public function getAgent()
    {
        return $this->agent;
    }

    public function getAgentId()
    {
        return $this->agent_id;
    }

    public function getAgentOptions()
    {
        return Droplet::where('type', 'agent')->get();
    }

    public function server()
    {
        return $this->hasOne(ServerModel::class, 'id', 'server_id');
    }

    /** @return ServerModel */
    public function getServer()
    {
        return $this->server;
    }

    public function getServerId()
    {
        return $this->server_id;
    }
}