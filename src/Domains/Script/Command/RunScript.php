<?php namespace SuperV\Modules\Supreme\Domains\Script\Command;

use Anomaly\Streams\Platform\Traits\Eventable;
use Anomaly\Streams\Platform\Traits\Transmitter;
use Symfony\Component\Process\Process;
use Vizra\SupervModule\DropperCommand\DropperCommandModel;
use SuperV\Modules\Supreme\Domains\Script\Script;
use SuperV\Modules\Supreme\Domains\Script\ScriptResult;

class RunScript
{
    use Eventable;

    /**
     * @var Script
     */
    private $script;
    /**
     * @var DropperCommandModel
     */
    private $model;

    public function __construct(Script $script, DropperCommandModel $model)
    {
        $this->script = $script;
        $this->model = $model;
    }

    public function handle()
    {
        $process = new Process('');
        $process->setTimeout(0);
        $process->setCommandLine($this->script->getTemplate());
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
              //  echo 'ERR > '.$buffer;
            } else {
                //echo 'OUT > '.$buffer;
            }
            $this->model->appendOutput($buffer)->save();
           // $this->fire(new ScriptResultStreamedEvent($this->model, $buffer));
        });


        $result = new ScriptResult($this->script);
        $result->setSuccess($process->isSuccessful());

        $result->setExitCode($process->getExitCode());
        $result->setExitText($process->getExitCodeText());

        if (!$result->isSuccess()) {
            $result->setOutput($process->getErrorOutput());
        }

        $this->script->cleanUp();
        $this->script->setResult($result);
    }
}