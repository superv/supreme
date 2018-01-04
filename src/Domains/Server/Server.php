<?php

namespace SuperV\Modules\Supreme\Domains\Server;

use SuperV\Modules\Nucleo\Domains\Entry\Nucleo;
use SuperV\Modules\Supreme\Domains\Account\Account;

class Server extends Nucleo
{
    protected $table = 'supreme_servers';

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
