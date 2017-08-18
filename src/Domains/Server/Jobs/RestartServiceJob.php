<?php namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Remote;
use SuperV\Platform\Domains\Task\TaskJob;
use SuperV\Platform\Domains\Task\TaskListener;

class RestartServiceJob implements TaskJob
{
    protected $listener;

    /**
     * @var ServerModel
     */
    private $server;

    private $service;

    public function __construct(ServerModel $server, $service)
    {
        $this->server = $server;
        $this->service = $service;
    }

    public function handle(Remote $remote)
    {
        return $remote->onServer($this->server)
                      ->setListener($this->listener)
                      ->setScript("service $this->service restart")
                      ->execute();
    }

    public function setListener(TaskListener $listener)
    {
        $this->listener = $listener;
    }
}