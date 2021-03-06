<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Accounts;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Model\Servers;
use SuperV\Platform\Domains\Feature\Feature;

class CreateServer extends Feature
{
    public static $route = 'post@api/supreme/servers';
//
//    public static $resolvable = [
//        'account' => Accounts::class,
//    ];

    public function handle(Servers $servers)
    {
        $server = $servers->create(
            [
                'name'    => $this->name,
                'slug'    => $this->slug,
                'ip'      => $this->ip,
                'port'    => $this->port,
                'account_id' => $this->account_id,
            ]
        );
//        if ($serviceList = $this->params->get('services')) {
//            if (!is_array($serviceList)) {
//                throw new \InvalidArgumentException('services must be array');
//            }
//            foreach ($serviceList as $slug) {
//                if ($service = $services->withSlug($slug)) {
//                    $server->services()->attach($service->id);
//                }
//            }
//        }

        return ['id' => $server->id];
    }
}