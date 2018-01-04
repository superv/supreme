<?php

use SuperV\Modules\Nucleo\NucleoFactory;
use SuperV\Modules\Supreme\Domains\Account\Account;
use SuperV\Modules\Supreme\Domains\Server\Server;
use SuperV\Platform\Domains\Database\Migration\Migration;

class SupervModulesSupremeCreateSupremeStruct extends Migration
{
    public function up()
    {
        app(NucleoFactory::class)
            ->create(Server::class, function ($fields) {
                $fields->string('name')->setLabel('Server Name');
                $fields->string('slug')->setLabel('Server Slug')->setUnique();
                $fields->string('distribution')->setLabel('Distribution')->nullable();
                $fields->string('ip')->setLabel('Ip Address');
                $fields->integer('port')->setLabel('Port')->nullable();

                $fields->relation('account')->setLabel('Account')->setConfig([
                    'related' => Account::class
                ]);
            });
    }

    public function down()
    {
        app(NucleoFactory::class)->drop(Server::class);
    }
}
