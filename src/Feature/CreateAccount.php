<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Accounts;
use SuperV\Platform\Domains\Feature\Feature;

class CreateAccount extends Feature
{
    public static $route = 'post@api/supreme/accounts';

    public function handle(Accounts $accounts)
    {
        $account = $accounts->create(
            [
                'name'        => $this->name,
                'slug'        => $this->slug,
                'user'        => $this->user,
                'private_key' => $this->private_key,
                'public_key'  => $this->public_key,
            ]
        );

        return ['id' => $account->id];
    }
}