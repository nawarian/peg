<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class OneOrMany implements Rule
{
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
            $span = $span->subtract($matched);
        }

        if ($span->stream === $text) {
            return false;
        }

        return (new Span($text))->subtract($span);
    }
}
