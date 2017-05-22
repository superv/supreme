<?php namespace SuperV\Modules\Supreme\Domains\Script;

use Illuminate\Contracts\Support\Arrayable;

class ScriptResult implements Arrayable
{
    protected $output;

    protected $success;

    protected $exitCode;

    protected $exitText;

    /** @var Script */
    protected $script;

    public function __construct(Script $script)
    {
        $this->script = $script;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'success'   => $this->success,
            'tokens'    => $this->script->getTokens(),
            'template'  => $this->script->getTemplate(),
            'output'    => $this->getOutput(),
            'exit_code' => $this->getExitCode(),
            'exit_text' => $this->getExitText(),
        ];
    }

    /**
     * @return mixed
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @param mixed $exitCode
     *
     * @return ScriptResult
     */
    public function setExitCode($exitCode)
    {
        $this->exitCode = $exitCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExitText()
    {
        return $this->exitText;
    }

    /**
     * @param mixed $exitText
     *
     * @return ScriptResult
     */
    public function setExitText($exitText)
    {
        $this->exitText = $exitText;

        return $this;
    }
}