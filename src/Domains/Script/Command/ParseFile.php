<?php namespace SuperV\Modules\Supreme\Domains\Script\Command;

class ParseFile
{
    private $tokens;
    private $template;

    public function __construct($template,  array $tokens = [])
    {
        $this->tokens = $tokens;
        $this->template = $template;
    }

    public function handle()
    {
        if (file_exists($this->template)) {
            return $this->parseString(file_get_contents($this->template), $this->tokens);
        }

        throw new \RuntimeException('File ' . $this->template . ' does not exist');
    }

    protected function parseString($script, array $tokens = [])
    {
        $values = array_values($tokens);

        $tokens = array_map(function ($token) {
            return '{{ ' . strtolower($token) . ' }}';
        }, array_keys($tokens));

        return str_replace($tokens, $values, $script);
    }

}