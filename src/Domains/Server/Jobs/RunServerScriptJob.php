<?php namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Script\StubBuilder;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;
use SuperV\Modules\Supreme\Domains\Server\Remote;
use SuperV\Platform\Domains\Task\Job;

class RunServerScriptJob extends Job
{
    /**
       * @var ServerModel
       */
      protected $server;

      protected $script;

      public function __construct(ServerModel $server)
      {
          $this->server = $server;
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

    public function handle(Remote $remote)
    {
        return $remote->onServer($this->server)
                      ->setListener($this->getListener())
                      ->setScript($this->script)
                      ->execute();
    }
}