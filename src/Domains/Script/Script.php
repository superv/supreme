<?php namespace SuperV\Modules\Supreme\Domains\Script;

use Illuminate\Foundation\Bus\DispatchesJobs;
use SuperV\Modules\Supreme\Domains\Script\Command\LocateScript;
use SuperV\Modules\Supreme\Domains\Script\Command\LocateWrapper;
use SuperV\Modules\Supreme\Domains\Script\Command\ParseTemplate;
use SuperV\Modules\Supreme\Domains\Script\Command\PrepareServerKey;
use SuperV\Modules\Supreme\Domains\Script\Command\PrepareServerTokens;
use SuperV\Modules\Supreme\Domains\Script\Command\WrapCommand;
use Vizra\SupervModule\Server\Contract\ServerInterface;

class Script
{
    use DispatchesJobs;

    protected $location;

    protected $template;

    protected $tokens = [];

    protected $namespace;

    protected $server;

    protected $local = false;

    protected $command;

    protected $key;

    /** @var  ScriptResult */
    protected $result;

    protected $wrapper;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function make()
    {
        $this->dispatch(new LocateScript($this));
//        $this->dispatch(new LocateWrapper($this));
//        $this->dispatch(new PrepareServerKey($this));
//        $this->dispatch(new PrepareServerTokens($this));
        $this->dispatch(new ParseTemplate($this));

        return $this;
    }

    public function cleanUp()
    {
        unlink($this->key);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     *
     * @return Script
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     *
     * @return Script
     */
    public function setTemplate($template)
    {
        $this->template = trim($template);

        return $this;
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param array $tokens
     *
     * @return Script
     */
    public function setTokens(array $tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function addTokens(array $tokens)
    {
        $this->tokens = array_merge($this->tokens, $tokens);
    }

    /**
     * @param ServerInterface $server
     *
     * @return Script
     */
    public function setServer(ServerInterface $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * @return ServerInterface
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param bool $local
     *
     * @return Script
     */
    public function setLocal($local)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocal()
    {
        return $this->local;
    }

    /**
     * @param mixed $command
     *
     * @return Script
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param mixed $key
     *
     * @return Script
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param ScriptResult $result
     *
     * @return Script
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return ScriptResult
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $wrapper
     *
     * @return Script
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }
}