<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class Sequence implements Rule
{
    use TokenValueResolver;

    private const TOKEN_NAME = 'Sequence';

    /**
     * @var Rule[]
     */
    public $rules;

    /**
     * @param Rule[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function match(string $text)
    {
        $span = new Span($text);

        $tokens = [];
        foreach ($this->rules as $rule) {
            if ($matched = $rule->match($span->stream)) {
                $value = $matched->value;
                if ($value instanceof Token) {
                    $value = $this->resolveTokenValueAsSpan($matched);
                }

                if ($rule instanceof NamedRule) {
                    $matched = new Token($rule->namedRule, $value);
                }

                /** @todo implement proper recursive traversal here */
                if (($rule instanceof OneOrMany || $rule instanceof ZeroOrMany) && $rule->rule instanceof NamedRule) {
                    $matched = new Token($rule->rule->namedRule, $value);
                }

                if ($value === false) {
                    break;
                }

                $span = $span->subtract($value);
                $tokens[] = $matched;
            } else {
                return false;
            }
        }

        return new Token(self::TOKEN_NAME, $tokens);
    }
}
