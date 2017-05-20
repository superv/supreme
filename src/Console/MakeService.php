<?php namespace SuperV\Modules\Supreme\Console;

use SuperV\Modules\Services\Feature\MakeServiceFeature;
use SuperV\Platform\Contracts\Command;

class MakeService extends Command
{
    protected $signature = 'make:service {slug}';

    public function handle()
    {
        $this->serve(new MakeServiceFeature($this->argument('slug')));
    }
}