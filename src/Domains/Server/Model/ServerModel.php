<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Platform\Domains\Model\EloquentModel;

class ServerModel extends EloquentModel
{
    protected $table = 'supreme_servers';

    public function account()
    {
        return $this->belongsTo(AccountModel::class, 'account_id');
    }

}