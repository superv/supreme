<?php namespace SuperV\Modules\Supreme\Domains\Service\Model;

use SuperV\Platform\Domains\Droplet\Model\DropletModel;
use SuperV\Platform\Domains\Model\EloquentModel;

class ServiceModel extends EloquentModel
{
    protected $table = 'supreme_services';

    public function agentx() {
        return $this->hasOne(DropletModel::class, 'id', 'agent');
    }
}