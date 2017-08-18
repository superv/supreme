<?php namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Script\ScriptBuilder;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Remote;
use SuperV\Platform\Domains\Task\Job;
use SuperV\Platform\Domains\Task\TaskListener;

class RunServerScriptJob extends Job
{
    /**
     * @var ServerModel
     */
    protected $server;

    protected $script;

    public function __construct(ServerModel $server, $title = null)
    {
        $this->server = $server;
        $this->title = $title;
    }

    public function handle(Remote $remote)
    {
        return $remote->onServer($this->server)
                      ->setListener($this->getListener())
                      ->setScript($this->script)
                      ->execute();
    }

    /**
     * @param mixed $script
     *
     * @return RunServerScriptJob
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    public function fromStub($stub, $tokens)
    {
        $script = superv(ScriptBuilder::class)->build($stub, $tokens);

        return $this->setScript($script);
    }
}