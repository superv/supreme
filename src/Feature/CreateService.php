<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Droplet\Model\Droplets;
use SuperV\Platform\Domains\Feature\Feature;

class CreateService extends Feature
{
    public static $route = 'post@api/supreme/services';

    protected $resolves = [
        'agent' => Droplets::class . "->id",
    ];

    public function handle(Services $services)
    {
        $attrs = $this->request->only(['name', 'slug', 'agent', 'type']);

        $service = $services->create($attrs);

        return ['id' => $service->id];
    }
}