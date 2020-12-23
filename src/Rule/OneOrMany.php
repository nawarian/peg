<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class OneOrMany implements Rule
{
    use TokenValueResolver;

    private const TOKEN_NAME = 'OneOrMany';

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
            $value = $matched->value;
            if ($value instanceof Token) {
                $value = $this->resolveTokenValueAsSpan($matched);
            }

            if ($value === false) {
                break;
            }

            $span = $span->subtract($value);
        }

        if ($span->stream === $text) {
            return false;
        }

        return new Token(self::TOKEN_NAME, (new Span($text))->subtract($span));
    }
}
