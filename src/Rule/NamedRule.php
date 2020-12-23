<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Parser;

final class NamedRule implements Rule
{
    /**
     * @var string
     */
    public $namedRule;

    /**
     * @var Parser
     */
    public $parser;

    public function __construct(string $namedRule, Parser $parser)
    {
        $this->namedRule = $namedRule;
        $this->parser = $parser;
    }

    public function match(string $text)
    {
        return $this->parser->rules[$this->namedRule]->match($text);
    }
}
