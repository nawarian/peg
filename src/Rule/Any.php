<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class Any implements Rule
{
    private const TOKEN_NAME = 'Any';

    public function match(string $text)
    {
        if (mb_strlen($text) > 0) {
            return new Token(self::TOKEN_NAME, new Span(mb_substr($text, 0, 1)));
        }

        return false;
    }
}
