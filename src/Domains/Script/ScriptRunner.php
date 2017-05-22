<?php namespace SuperV\Modules\Supreme\Domains\Script;

use Anomaly\Streams\Platform\Traits\Eventable;
use Symfony\Component\Process\Process;

class ScriptRunner
{
    use Eventable;
    
    /**
     * @param Script $script
     * @param callable|null $callback
     *
     * @return ScriptResult
     */
    public function run(Script $script, callable $callback = null)
    {
        $result = new ScriptResult($script);
        
        try {
            $process = new Process($script->getTemplate());
            $process->setTimeout(0);
            $process->run($callback);
            
            $result->setSuccess($process->isSuccessful());
            $result->setExitCode($process->getExitCode());
            $result->setExitText($process->getExitCodeText());
            
            if (!$result->isSuccess()) {
                $result->setOutput($process->getErrorOutput());
            }
        } catch (\Exception $e) {
            $result->setSuccess(false);
            $result->setOutput($e->getMessage());
        }
        
        $script->cleanUp();
        $script->setResult($result);
        
        return $result;
    }
}