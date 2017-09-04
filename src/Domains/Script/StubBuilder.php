<?php namespace SuperV\Modules\Supreme\Domains\Script;

use SuperV\Platform\Domains\Droplet\Resource\ResourceLocator;
use SuperV\Platform\Support\Parser;

class StubBuilder
{
    /**
     * @var ResourceLocator
     */
    private $locator;

    /**
     * @var TemplateParser
     */
    private $parser;

    private $wrapper;

    public function __construct(ResourceLocator $locator, Parser $parser)
    {
        $this->locator = $locator;
        $this->parser = $parser;
    }

    public function wrapper($stub, $tokens = [])
    {
        $this->wrapper = ['stub' => $stub, 'tokens' => $tokens];

        return $this;
    }

    public function build($stub, $tokens = null)
    {
        $script = $this->parse($this->locate($stub), $tokens);

        if (! $this->wrapper) {
            return $script;
        }

        $tokens = $this->wrapper['tokens'];
        array_set($tokens, 'content', $script);
        return $this->parse($this->locate($this->wrapper['stub']), $tokens);

    }

    /**
     * @param $stub
     *
     * @return null|string
     */
    protected function locate($stub)
    {
        if (! str_is('*::*', $stub)) {
            $stub = 'superv.modules.supreme::' . $stub;
         }
        $location = $this->locator->locate($stub, 'stub');
        if (! file_exists($location)) {
            throw new \RuntimeException("Stub {$stub} not found at location {$location}");
        }

        return $location;
    }

    /**
     * @param $tokens
     * @param $location
     *
     * @return mixed
     */
    protected function parse($location, $tokens)
    {
        $script = $this->parser->delimiters('{{ ', ' }}')->parse(file_get_contents($location), $tokens);

        return $script;
    }
}