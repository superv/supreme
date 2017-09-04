<?php namespace SuperV\Modules\Supreme\Domains\Server;

use InvalidArgumentException;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;

class Remote
{
    /** @var  ServerModel */
    protected $model;

    protected $server;

    protected $keyFile;

    protected $output;

    protected $success;

    protected $local = false;

    /** @var  callable */
    protected $listener;

    protected $script;

    /**
     * @var Process
     */
    private $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    public function onServer(Server $server)
    {
        $this->server = $server;
        $this->model = $server->getModel();

        $this->keyFile = (new SSHKey($this->model->getAccount()->private_key))->make()->getTempFileLocation();

        return $this;
    }

    private function wrapWithSSH($script)
    {
        if (! $this->keyFile || ! file_exists($this->keyFile)) {
            throw new InvalidArgumentException ('Private key file must exist');
        }

        $options = [
            'CheckHostIP'            => 'no',
            'IdentitiesOnly'         => 'yes',
            'StrictHostKeyChecking'  => 'no',
            'PasswordAuthentication' => 'no',
            'ConnectTimeout'         => 3,
            'IdentityFile'           => $this->keyFile,
        ];

        $wrapper = 'ssh';
        foreach ($options as $key => $value) {
            $wrapper .= " -o {$key}={$value}";
        }

        $wrapper .= " -p {$this->port()} {$this->user()}@{$this->ip()}";
        $wrapper .= " 'DEBIAN_FRONTEND=noninteractive bash -s'  << 'EOF'\n";
        $wrapper .= "set -e \n {$script} \nEOF";

        return $wrapper;
    }

    public function execute()
    {
        $script = $this->script;
        if (! $this->local) {
            $script = $this->wrapWithSSH($script);
        }

        $listener = $this->listener;
        if (is_object($listener) && method_exists($listener, 'callable')) {
            $listener = $listener->callable();
        }

        try {
            $this->process->run($script, $listener);
            $this->output = $this->process->output();
            $this->success = $this->process->success();
        } catch (\Exception $e) {
            $this->output = $e->getMessage();
        }

        return $this;
    }

    public function close()
    {
        if ($this->keyFile) {
            unlink($this->keyFile);
        }
    }

    public function withKeyFile($keyFile)
    {
        $this->keyFile = $keyFile;

        return $this;
    }

    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    public function output()
    {
        return $this->output;
    }

    public function success()
    {
        return $this->success;
    }

    public function forceSuccess()
    {
        if (! $this->success) {
            \Log::error($this->script);
            throw new ServerException($this->output());
        }

        return $this;
    }

    public function port()
    {
        return $this->model->port ?: 22;
    }

    public function user()
    {
        return $this->model->account->user;
    }

    public function ip()
    {
        return $this->model->ip;
    }

    /**
     * @param callable $listener
     *
     * @return Remote
     */
    public function setListener($listener): Remote
    {
        $this->listener = $listener;

        return $this;
    }
}