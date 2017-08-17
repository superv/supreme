<?php namespace SuperV\Modules\Supreme\Feature;

use SuperV\Modules\Supreme\Domains\Service\Model\Services;
use SuperV\Platform\Domains\Droplet\Agent\Agent;
use SuperV\Platform\Domains\Droplet\Droplet;
use SuperV\Platform\Domains\Feature\Feature;
use SuperV\Platform\Domains\Task\Features\DeployTask;
use SuperV\Platform\Domains\Task\Model\TaskModel;
use SuperV\Platform\Domains\Task\Model\Tasks;
use SuperV\Platform\Domains\Task\Task;

class InstallService extends Feature
{
    public static $route = 'any@api/supreme/services/{id}/install';

    public $force = true;

    public function handle(Tasks $tasks, Services $services)
    {
        if (!$service = $services->find(request()->route('id'))) {
            throw new \Exception('Service not found');
        }

        /** @var Agent $agent */
        $agent = Droplet::from($service->agent);

        // create the task
        $taskModel = $tasks->create([
            'server_id'  => $service->server->id,
            'payload'    => [
                'commands' => [
                    $agent->getCommand('install')
                ],
            ],
            'status'     => TaskModel::PENDING,
            'created_at' => mysql_now(),
        ]);

        $this->dispatch(new DeployTask(new Task($taskModel), $service));


        //        if (!$this->force && $remote->config("{$agent->identifier()}.installed")) {
        //            throw new \Exception('Already installed');
        //        }


        //        if ($result) {
        //            $remote->config("{$this->service->getAgent()->identifier()}.installed", true);
        //        }
    }


}