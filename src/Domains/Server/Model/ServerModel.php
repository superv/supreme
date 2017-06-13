<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Nucleus\Domains\Entry\Nucleus;

class ServerModel extends Nucleus
{
//    public static function __callStatic($method, $parameters)
//    {
//        return (new static)->$method(...$parameters);
//    }
//


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



