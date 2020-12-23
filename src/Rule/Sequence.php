<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class Sequence implements Rule
{
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
        $result = new Span('');

        foreach ($this->rules as $rule) {
            if ($matched = $rule->match($span->stream)) {
                $span = $span->subtract($matched);
                $result = $result->add($matched);
            } else {
                return false;
            }
        }

        return $result->len > 0 ? $result : false;
    }
}
