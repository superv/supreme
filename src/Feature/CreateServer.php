<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Accounts;
use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Feature\Feature;

class CreateServer extends Feature
{
    public static $route = 'post@api/supreme/servers';

    protected $resolves = [
        'account' => Accounts::class . "->id",
    ];

    public function handle(Servers $servers)
    {
        $attrs = $this->request->only(['name', 'slug', 'ip', 'port']);
        $attrs['account_id'] = $this->request->account;

        $server = $servers->create($attrs);

        return ['id' => $server->id];
    }
}