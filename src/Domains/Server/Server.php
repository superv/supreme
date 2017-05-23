<?php namespace SuperV\Modules\Supreme\Domains\Server;

use InvalidArgumentException;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;

class Server
{
    use RemoteHands;

    /** @var  ServerModel */
    protected $model;

    protected $keyFile;

    protected $output;

    protected $success;

    protected $local = false;

    /**
     * @var Process
     */
    private $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
    }

    public function on($ip, $user = 'root', $port = 22)
    {
        $this->ip = $ip;
        $this->user = $user;
        $this->port = $port;

        $this->local = false;

        return $this;
    }

    public function onServer(ServerModel $server)
    {
        $this->model = $server;

        $this->keyFile = (new SSHKey($server->account->private_key))->make()->getTempFileLocation();

        return $this;
    }

    public function withKeyFile($keyFile)
    {
        $this->keyFile = $keyFile;

        return $this;
    }

    public function cmd($command)
    {
        if (!$this->local) {
            $command = $this->wrapWithSSH($command);
        }

        try {
            $this->process->run($command);
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

    public function config($key = null, $value = null)
    {
        $configFile = '/usr/local/superv/.superv';
        if (!$this->fileExists('/usr/local/superv/.superv')) {
            $this->mkdirR(dirname($configFile));
            $this->saveToFile('{}', $configFile);
        }
        $config = json_decode($this->getFile($configFile), true);

        if ($value) {
            array_set($config, $key, $value);
            $this->saveToFile(json_encode($config, JSON_PRETTY_PRINT), '/usr/local/superv/.superv');
            return $this;
        }

        return $key ? array_get($config, $key) : $config;
    }

    public function output()
    {
        return $this->output;
    }

    public function success()
    {
        return $this->success;
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

    private function wrapWithSSH($command)
    {
        if (!$this->keyFile || !file_exists($this->keyFile)) {
            throw new InvalidArgumentException ('Private key file must exist');
        }

        $options = [
            'CheckHostIP'            => 'no',
            'IdentitiesOnly'         => 'yes',
            'StrictHostKeyChecking'  => 'no',
            'PasswordAuthentication' => 'no',
            'IdentityFile'           => $this->keyFile,
        ];

        $wrapper = 'ssh';
        foreach ($options as $key => $value) {
            $wrapper .= " -o {$key}={$value}";
        }

        $wrapper .= " -p {$this->port()} {$this->user()}@{$this->ip()}";
        $wrapper .= " 'DEBIAN_FRONTEND=noninteractive bash -s'  << 'EOF'\n";
        $wrapper .= "set -e \n {$command} \nEOF";

        return $wrapper;
    }
}