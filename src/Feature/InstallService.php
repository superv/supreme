<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Server\Model\Eloquent\Servers;
use SuperV\Modules\Supreme\Domains\Server\Server;
use SuperV\Modules\Supreme\Domains\Service\Model\ServiceModel;
use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Droplet\Droplet;
use SuperV\Platform\Domains\Feature\Feature;
use SuperV\Platform\Domains\Task\Model\Tasks;

class InstallService extends Feature
{
    public static $route = 'any@api/supreme/services/install';

//    public static $resolvable = [
//        'server'  => Servers::class,
//        'service' => Services::class,
//    ];

    public function handle(Tasks $tasks)
    {
        $service = ServiceModel::find($this->service_id);

        $agent = Droplet::from($service->agent);
        $command = $agent->getCommand('install');

        // create
        $task = $tasks->create([
            'server_id'  => $service->server->id,
            'payload'    => [
                'command' => serialize($command),
            ],
            'status'     => 'pending',
            'created_at' => mysql_now(),
        ]);

        // run
        $task = $tasks->find($task->id);
        $command = unserialize($task->payload['command']);

        $server = superv(Server::class)->onServer($service->server);

        if (!$this->force && $server->config("{$agent->identifier()}.installed")) {
            throw new \Exception('Already installed');
        }

        $result = $this->dispatchJob(new $command($server));

        if ($result) {
            $server->config("{$agent->identifier()}.installed", true);
        }

        return $result;
    }
}