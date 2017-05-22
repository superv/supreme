<?php namespace SuperV\Modules\Supreme\Domains\Server;

interface Process
{
    public function run($command, callable $callback = null);

    public function success();

    public function output();
}