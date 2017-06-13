<?php namespace SuperV\Modules\Supreme\Domains\Server\Model\Nucleus;

use SuperV\Modules\Supreme\Domains\Server\Model\Contracts\ServerModelInterface;
use SuperV\Nucleus\Domains\Entry\Nucleus;

class ServerModel extends Nucleus implements ServerModelInterface
{
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}