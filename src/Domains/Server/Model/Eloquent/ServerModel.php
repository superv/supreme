<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Eloquent;

use SuperV\Modules\Supreme\Domains\Server\Model\AccountModel;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModelInterface;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Platform\Domains\Model\EloquentModel;

class ServerModel extends EloquentModel implements ServerModelInterface
{
    protected $table = 'supreme_servers';

    public function account()
    {
        return $this->belongsTo(AccountModel::class, 'account_id');
    }

    public function services()
    {
        return $this->hasMany(ServiceModel::class, 'server_id');
    }

    public function ip()
    {
        return $this->ip;
    }

}