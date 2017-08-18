<?php namespace SuperV\Modules\Supreme\Domains\Script;

use SuperV\Platform\Domains\Droplet\Resource\ResourceLocator;

class ScriptBuilder
{
    /**
     * @var ResourceLocator
     */
    private $locator;

    /**
     * @var TemplateParser
     */
    private $parser;

    public function __construct(ResourceLocator $locator, TemplateParser $parser)
    {
        $this->locator = $locator;
        $this->parser = $parser;
    }

    public function build($stub, $tokens)
    {
        $location = $this->locator->locate($stub, 'stub');

        $script = $this->parser->parse($location, $tokens);

        return $script;
    }
}