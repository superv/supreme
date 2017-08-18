<?php namespace SuperV\Modules\Supreme\Domains\Server;

use InvalidArgumentException;
use SuperV\Modules\Supreme\Domains\Script\Script;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;

class Remote
{
    /** @var  \SuperV\Modules\Supreme\Domains\Server\Model\ServerModel */
    protected $model;

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

    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

    public function execute()
    {
        $script = $this->script;
        if (!$this->local) {
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

        if (!$this->success) {
            throw new ServerException($this->output);
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

    private function wrapWithSSH($script)
    {
        if (!$this->keyFile || !file_exists($this->keyFile)) {
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

    protected function makeScript($template, $tokens)
    {
        return (new Script($template))
            ->setTokens($tokens)
            ->setLocal(false)
            ->make()
            ->getTemplate();
    }

    protected function runScript($template, $tokens)
    {
        return $this->setScript($this->makeScript($template, $tokens));
    }

    public function fileExists($path)
    {
        $script = $this->makeScript('CheckFileExists', ['path' => $path]);

        return $this->setScript($script)->execute()->success();
    }

    public function getFile($file)
    {
        $this->setScript("cat {$file}");

        return $this->output();
    }

    public function saveToFile($content, $file)
    {
        $result = $this->runScript('SaveToFile', [
            'content' => $content,
            'file'    => $file,
        ]);

        if (!$result->success()) {
            throw new \Exception($result->output());
        }

        return true;
    }

    public function symlink($what, $where)
    {
        return $this->run("ln -s {$what} {$where}");
    }

    public function run($command)
    {
        $result = $this->runScript('RunCommand', [
            'command' => $command,
        ]);

        if (!$result->success()) {
            throw new \Exception($result->output());
        }

        return $result;
    }

    public function delete($what)
    {
        return $this->run("rm {$what}");
    }

    public function chownR($target, $user, $group = null)
    {
        return $this->chown($target, $user, $group, true);
    }

    public function chown($target, $user, $group = null, $recursive = false)
    {
        return $this->run("chown " . ($recursive ? '-R' : '') . " {$user}:" . ($group ? ':' . $group : '') . " {$target}");
    }

    public function chmodR($target, $permissions)
    {
        return $this->chmod($target, $permissions, true);
    }

    public function chmod($target, $permissions, $recursive = false)
    {
        return $this->run("chmod " . ($recursive ? '-R' : '') . " {$permissions} {$target}");
    }

    public function deleteDirectory($user, $directory)
    {
        $dir = "/home/{$user}/{$directory}";

        return $this->run("rm -Rf {$dir}");
    }

    public function mkdirR($directory, $perms = null)
    {
        $this->mkdir($directory, $perms, true);
    }

    public function mkdir($directory, $perms = null, $recursive = true)
    {
        $this->run("mkdir " . ($recursive ? '-p' : '') . " {$directory}");
        if ($perms) {
            $this->chmod($directory, $perms);
        }
    }

    public function addUser($user, $password)
    {
        $result = $this->runScript('AddSystemUser', [
            'user'     => $user,
            'password' => $password,
        ]);

        if (!$result->success()) {
            throw new \Exception($result->output());
        }

        return true;
    }

    public function addToGroup($user, $group)
    {
        $result = $this->runScript('AddUserToGroup', [
            'user'  => $user,
            'group' => $group,
        ]);

        if (!$result->success()) {
            throw new \Exception($result->output());
        }

        return true;
    }
}