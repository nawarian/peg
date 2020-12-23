<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class Pattern implements Rule
{
    private const TOKEN_NAME = 'Pattern';

    /**
     * @var string
     */
    public $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function match(string $text)
    {
        if (preg_match("#^{$this->pattern}#", $text, $matches) === 1) {
            return new Token(self::TOKEN_NAME, new Span($matches[0]));
        }

        return false;
    }
}
