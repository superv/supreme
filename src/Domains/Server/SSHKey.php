<?php namespace SuperV\Modules\Supreme\Domains\Server;

class SSHKey
{
    private $key;

    private $location;

    public function __construct($key)
    {
        if (!$key) {
            throw new \InvalidArgumentException('No key is provided');
        }
        $this->key = $key;
    }

    public function make()
    {
        $this->location = tempnam(storage_path('app/'), 'sshkey');
        file_put_contents($this->location, trim($this->key));

        return $this;
    }

    public function getTempFileLocation()
    {
        return $this->location;
    }

    public function destroy()
    {
        unlink($this->location);
    }
}