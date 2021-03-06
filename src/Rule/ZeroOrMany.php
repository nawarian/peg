<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class ZeroOrMany implements Rule
{
    private const TOKEN_NAME = 'ZeroOrMany';

    /**
     * @var Rule
     */
    public $rule;

    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    public function match(string $text)
    {
        $span = new Span($text);

        while ($matched = $this->rule->match($span->stream)) {
            $span = $span->subtract($matched->value);
        }

        return new Token(self::TOKEN_NAME, (new Span($text))->subtract($span));
    }
}
