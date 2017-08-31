<?php namespace SuperV\Modules\Supreme\Domains\Drop\Model;

use SuperV\Modules\Supreme\Model\Entry\DropEntryModel;
use SuperV\Platform\Domains\Droplet\Model\DropletModel;

class DropModel extends DropEntryModel
{
    public $timestamps = true;

    public function agent()
    {
        return $this->hasOne(DropletModel::class, 'id', 'agent_id');
    }

    /** @return DropletModel */
    public function getAgent()
    {
        return $this->agent;
    }

    public function getAgentId()
    {
        return $this->agent_id;
    }
}