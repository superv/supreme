<?php namespace SuperV\Modules\Supreme\Domains\Script\Command;

use SuperV\Modules\Supreme\Domains\Script\Script;
use Vizra\SupervModule\SupervModule;

class LocateTemplate
{
    private $namespace;
    
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function handle(SupervModule $module)
    {
        if (str_is('*::*', $this->namespace)) {
            $parts = explode('::', $this->namespace);
            $dropper = $parts[0];
            $file = $parts[1];
            $location = base_path('droppers/' . $dropper . '/templates/' . $file);

        } else {
            $location = $module->getPath('resources/templates/' . $this->namespace);
        }

        return str_replace('.', '/', $location).  '.template';
    }
}