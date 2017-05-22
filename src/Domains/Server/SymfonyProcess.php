<?php namespace SuperV\Modules\Supreme\Domains\Server;

class SymfonyProcess implements Process
{
    /** @var  \Symfony\Component\Process\Process */
    protected $process;

    public function run($command, callable $callback = null)
    {
        $this->process = new \Symfony\Component\Process\Process($command);
        $this->process->setTimeout(0);
        $this->process->run($callback);
    }

    public function success()
    {
        return $this->process->isSuccessful();
    }

    public function output()
    {
        $output = $this->process->isSuccessful() ? $this->process->getOutput() : $this->process->getErrorOutput();
        return trim($output);
    }
}