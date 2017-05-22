<?php namespace SuperV\Modules\Supreme\Domains\Script\Command;

use Illuminate\Foundation\Bus\DispatchesJobs;
use SuperV\Modules\Supreme\Domains\Script\Script;

class ParseTemplate
{
    use DispatchesJobs;
    /**
     * @var Script
     */
    private $script;

    public function __construct(Script $script)
    {
        $this->script = $script;
    }

    public function handle()
    {
        if (!file_exists($this->script->getLocation())) {
            throw new \RuntimeException('Template ' . $this->script->getLocation() . ' does not exist');
        }

        $template = $this->parseString(file_get_contents($this->script->getLocation()));

        $this->script->setTemplate($template);
    }

    protected function parseString($template)
    {
        $values = array_values($this->script->getTokens());

        $tokens = array_map(function ($token) {
            return '{{ ' . strtolower($token) . ' }}';
        }, array_keys($this->script->getTokens()));

        return str_replace($tokens, $values, $template);
    }
}