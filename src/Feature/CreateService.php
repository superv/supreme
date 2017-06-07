<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Eloquent\Servers;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Droplet\Model\Droplets;
use SuperV\Platform\Domains\Feature\Feature;

class CreateService extends Feature
{
    public static $route = 'post@api/supreme/services';

    public static $resolvable = [
        'agent'  => Droplets::class . '->id',
        'server' => Servers::class . '->id',
    ];

    public function handle(Services $services)
    {
        $service = $services->create([
            'name'     => $this->name,
            'slug'     => $this->slug,
            'type'     => $this->type,
            'agent_id' => $this->agent,
            'server_id' => $this->server
        ]);

        return ['id' => $service->id];
    }
}