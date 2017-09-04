<?php

namespace SuperV\Modules\Supreme\Domains\Server\Jobs;

use SuperV\Modules\Supreme\Domains\Script\StubBuilder;

class MakeStub
{
    private $stub;

    private $params;

    public function __construct($stub, $params)
    {
        $this->stub = $stub;
        $this->params = $params;
    }

    public function handle(StubBuilder $builder)
    {
        return $builder->build($this->stub, $this->params);
    }
}