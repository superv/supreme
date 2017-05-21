<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Feature\Feature;

class InstallService extends Feature
{
    public static $route = 'post@api/supreme/servers/install';

    protected $resolves = [
        'server'  => Servers::class,
        'service' => Services::class,
    ];

    public function handle(Services $services, Servers $servers)
    {
        dd($this->request->service->agentx);
    }
}