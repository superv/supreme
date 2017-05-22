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

    public function handle(Servers $servers, Services $services)
    {
        $attrs = $this->params->only(['name', 'slug', 'ip', 'port']);
        $attrs['account_id'] = $this->params->get('account');

        /** @var \SuperV\Modules\Supreme\Domains\Server\Model\ServerModel $server */
        $server = $servers->create($attrs);
        if ($serviceList = $this->params->get('services')) {
            if (!is_array($serviceList)) {
                throw new \InvalidArgumentException('services must be array');
            }
            foreach ($serviceList as $slug) {
                if ($service = $services->withSlug($slug)) {
                    $server->services()->attach($service->id);
                }
            }
        }

        return ['id' => $server->id];
    }
}