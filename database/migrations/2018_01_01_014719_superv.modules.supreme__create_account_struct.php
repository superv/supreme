<?php

use SuperV\Modules\Nucleo\NucleoFactory;
use SuperV\Modules\Supreme\Domains\Account\Account;
use SuperV\Platform\Domains\Database\Migration\Migration;

class SupervModulesSupremeCreateAccountStruct extends Migration
{
    public function up()
    {
        app(NucleoFactory::class)
            ->create(Account::class, function ($fields) {
                $fields->string('name')->setLabel('Account Name');
                $fields->string('slug')->setLabel('Account Slug')->setUnique();
                $fields->string('username')->setLabel('Username')->setRules('alphanum');
                $fields->text('private_key')->setLabel('Private Key')->nullable();
                $fields->text('public_key')->setLabel('Public Key')->nullable();
            });
    }

    public function down()
    {
        app(NucleoFactory::class)->drop(Account::class);
    }
}
