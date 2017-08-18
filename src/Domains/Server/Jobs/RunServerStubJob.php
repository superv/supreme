<?php namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Script\ScriptBuilder;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Remote;
use SuperV\Platform\Domains\Task\TaskJob;
use SuperV\Platform\Domains\Task\TaskListener;

class RunServerStubJob implements TaskJob
{
    protected $listener;

    /**
     * @var ServerModel
     */
    private $server;

    private $stub;

    private $tokens;

    public function __construct(ServerModel $server, $stub, $tokens)
    {
        $this->server = $server;
        $this->stub = $stub;
        $this->tokens = $tokens;
    }

    public function handle(Remote $remote, ScriptBuilder $builder)
    {
        $script = $builder->build($this->stub, $this->tokens);
        return $remote->onServer($this->server)
                            ->setListener($this->listener)
                            ->setScript($script)
                            ->execute();
    }

    public function setListener(TaskListener $listener)
    {
        $this->listener = $listener;
    }
}