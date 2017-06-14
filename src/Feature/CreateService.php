<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Feature\Feature;

class CreateService extends Feature
{
    public static $route = 'post@api/supreme/services';

//    public static $resolvable = [
//        'agent'  => Droplets::class . '->id',
//        'server' => Servers::class . '->id',
//    ];

    public function handle()
    {
        $service = ServiceModel::create([
            'name'      => $this->name,
            'slug'      => $this->slug,
            'type'      => $this->type,
            'agent_id'  => $this->agent_id,
            'server_id' => $this->server_id,
        ]);

        return ['id' => $service->id()];
    }
}