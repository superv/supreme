<?php

namespace SuperV\Modules\Supreme\Domains\Server;

use SuperV\Modules\Supreme\Domains\Script\StubBuilder;
use SuperV\Modules\Supreme\Domains\Server\Model\ServerModel;

class Server
{
    /**
     * @var ServerModel
     */
    private $model;

    public function __construct(ServerModel $model)
    {
        $this->model = $model;
    }

    /** @return Remote */
    public function execute($script, $listener = null)
    {
        return app(Remote::class)->onServer($this)
                                 ->setListener($listener)
                                 ->setScript($script)
                                 ->execute();
    }

    protected function fromStub($stub, $tokens)
    {
        return app(StubBuilder::class)->build($stub, $tokens);
    }

    /**
     * @return ServerModel
     */
    public function getModel(): ServerModel
    {
        return $this->model;
    }

    public function getFile($file)
    {
        return $this->execute("cat {$file}")
                    ->output();
    }

    public function fileExists($path)
    {
        $script = $this->fromStub('file_exists', compact('path'));

        return $this->execute($script)
                    ->success();
    }

    public function symlink($what, $where)
    {
        return $this->execute("ln -s {$what} {$where}")
                    ->forceSuccess();
    }

    public function delete($what)
    {
        return $this->execute("rm {$what}");
    }

    public function chownR($target, $user, $group = null)
    {
        return $this->chown($target, $user, $group, true);
    }

    public function chown($target, $user, $group = null, $recursive = false)
    {
        return $this->execute("chown ".($recursive ? '-R' : '')." {$user}:".($group ? ':'.$group : '')." {$target}");
    }

    public function chmodR($target, $permissions)
    {
        return $this->chmod($target, $permissions, true);
    }

    public function chmod($target, $permissions, $recursive = false)
    {
        return $this->execute("chmod ".($recursive ? '-R' : '')." {$permissions} {$target}");
    }

    public function deleteDirectory($user, $directory)
    {
        $dir = "/home/{$user}/{$directory}";

        return $this->execute("rm -Rf {$dir}");
    }

    public function mkdirR($directory, $perms = null)
    {
        $this->mkdir($directory, $perms, true);
    }

    public function mkdir($directory, $perms = null, $recursive = true)
    {
        $this->execute("mkdir ".($recursive ? '-p' : '')." {$directory}");
        if ($perms) {
            $this->chmod($directory, $perms);
        }
    }

    public function addUser($user, $password)
    {
        $script = $this->fromStub('add_user', [
            'user'     => $user,
            'password' => $password,
        ]);

        return $this->execute($script)
                    ->forceSuccess();
    }

    public function addToGroup($user, $group)
    {
        return $this->execute("usermod -aG {$user} {$group}")
                    ->forceSuccess();
    }

    public function saveToFile($content, $target)
    {
        $script = $this->fromStub('save_to_file', [
            'content' => $content,
            'target'    => $target,
        ]);

        return $this->execute($script)
                    ->forceSuccess();
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
}