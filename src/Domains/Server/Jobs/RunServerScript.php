<?php namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Script\StubBuilder;
use SuperV\Modules\Supreme\Domains\Server\Terminal;
use SuperV\Platform\Domains\Task\Job;

class RunServerScript extends Job
{
    protected $script;

    /**
     * @var Terminal
     */
    private $server;

    public function __construct(Terminal $server, $script = null)
    {
        $this->server = $server;
        $this->script = $script;
    }

    public function script($script)
    {
        $this->script = $script;
    }

    public function stub($stub, $tokens)
    {
        $this->script = app(StubBuilder::class)->build($stub, $tokens);

        return $this;
    }

    public function handle()
    {
        return $this->server->execute($this->script, $this->listener)->forceSuccess();
    }
}