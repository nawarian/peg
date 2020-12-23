<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class Not implements Rule
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
        if ($this->rule->match($text) === false) {
            return new Span($text);
        }

        return false;
    }
}
