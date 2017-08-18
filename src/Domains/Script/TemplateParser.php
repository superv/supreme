<?php namespace SuperV\Modules\Supreme\Domains\Script;

class TemplateParser
{
    public function parse($location, array $tokens = [])
    {
        if (file_exists($location)) {
            return $this->parseString(file_get_contents($location), $tokens);
        }

        throw new \RuntimeException('File ' . $location . ' does not exist');
    }

    public function parseString($script, array $tokens = [])
    {
        $values = array_values($tokens);

        $tokens = array_map(function ($token) {
            return '{{ ' . strtolower($token) . ' }}';
        }, array_keys($tokens));

        return str_replace($tokens, $values, $script);
    }
}