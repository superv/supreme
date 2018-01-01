<?php namespace SuperV\Modules\Supreme\Domains\Drop\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Model\Entry\DropEntryModel;
use SuperV\Platform\Domains\Droplet\Droplet;
use SuperV\Platform\Domains\Entry\EntryModel;

class DropModel extends DropEntryModel
{
    public $timestamps = true;

    public function related()
    {
        return $this->morphTo();
    }

    public function getRelated()
    {
        return $this->related;
    }

    /**
     * @param EntryModel $related
     *
     * @return $this
     */
    public function setRelated(EntryModel $related)
    {
        $this->update([
            'related_type' => get_class($related),
            'related_id'   => $related->getId(),
        ]);
    }

    public function agent()
    {
        return $this->hasOne(Droplet::class, 'id', 'agent_id');
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

    public function getServer()
    {
        return $this->server;
    }

    public function server()
    {
        return $this->belongsTo(ServerModel::class, 'server_id', 'id');
    }
}