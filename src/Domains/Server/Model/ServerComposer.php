<?php namespace SuperV\Modules\Supreme\Domains\Server\Model;

use SuperV\Modules\Supreme\Domains\Server\Model\Eloquent\Servers;

class ServerComposer
{
    public static $route = 'get@api/supreme/servers/{id}';

    public function handle($serverId, Servers $servers)
    {
        $server = $servers->find($serverId);

        return $server->name;
    }

}