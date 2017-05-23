<?php namespace SuperV\Modules\Supreme\Domains\Server;

use Illuminate\Foundation\Bus\DispatchesJobs;
use SuperV\Modules\Supreme\Domains\Script\Command\ParseFile;
use SuperV\Modules\Supreme\Domains\Script\Script;
use SuperV\Platform\Domains\Droplet\Jobs\LocateResourceJob;

trait RemoteHands
{
    use DispatchesJobs;

    public function fileExists($path)
    {
        $script = $this->makeScript('CheckFileExists', ['path' => $path]);

        return $this->cmd($script)->success();
    }

    public function getFile($file)
    {
        $this->cmd("cat {$file}");

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

    public function reload($service)
    {
        return $this->service($service, 'reload');
    }

    public function service($service, $action)
    {
        return $this->run("service {$service} {$action}");
    }

    public function restart($service)
    {
        return $this->service($service, 'restart');
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

    public function template($template, $tokens)
    {
        $location = $this->dispatch(new LocateTemplate($template));

        return $this->dispatch(new ParseFile($location, $tokens));
    }

    protected function makeScript($template, $tokens)
    {
        return (new Script($template))
            ->setTokens($tokens)
            ->setLocal(false)
            ->make()->getTemplate();
    }

    protected function runScript($template, $tokens)
    {
        return $this->cmd($this->makeScript($template, $tokens));
    }
}