<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class Not implements Rule
{
    private const TOKEN_NAME = 'Not';

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
            return new Token(self::TOKEN_NAME, new Span($text));
        }

        return false;
    }
}
