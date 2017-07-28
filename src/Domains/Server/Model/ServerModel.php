<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;

class ServerModel extends ServerEntryModel
{
    public function account()
    {
        return $this->hasOne(AccountModel::class, 'id', 'account_id');
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



