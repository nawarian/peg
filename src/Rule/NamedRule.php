<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Parser;
use Nawarian\PEG\Token;

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
        return new Token($this->namedRule, $this->parser->rules[$this->namedRule]->match($text));
    }
}
