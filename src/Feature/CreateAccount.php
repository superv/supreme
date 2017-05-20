<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Accounts;
use SuperV\Platform\Domains\Feature\Feature;

class CreateAccount extends Feature
{
    public static $route = 'post@api/supreme/accounts';

    public function handle(Accounts $accounts)
    {
        \Log::info('reg', $this->request->all());
        $attrs = $this->request->only(['name', 'slug', 'user', 'private_key', 'public_key']);

        $account = $accounts->create($attrs);

        return ['id' => $account->id];
    }
}