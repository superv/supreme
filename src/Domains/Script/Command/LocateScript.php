<?php namespace SuperV\Modules\Supreme\Domains\Script\Command;

use SuperV\Modules\Supreme\Domains\Script\Script;
use SuperV\Platform\Domains\Droplet\Model\DropletCollection;
use Vizra\SupervModule\SupervModule;

class LocateScript
{
    protected $script;

    public function __construct(Script $script)
    {
        $this->script = $script;
    }

    public function handle(DropletCollection $droplets)
    {
        $namespace = $this->script->getNamespace();
        if (str_is('*::*', $namespace)) {
            $parts = explode('::', $namespace);
            $dropper = $parts[0];
            $file = $parts[1];
            $location = base_path('droppers/' . $dropper . '/templates/' . $file);

        } else {
            $droplet = $droplets->get('superv.modules.supreme');
            $location = base_path($droplet->getPath() . '/resources/templates/' . $namespace);
        }

        $this->script->setLocation(str_replace('.', '/', $location) . '.sh');
    }
}