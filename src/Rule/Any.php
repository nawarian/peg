<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class Any implements Rule
{
    public function match(string $text)
    {
        if (mb_strlen($text) > 0) {
            return new Span(mb_substr($text, 0, 1));
        }

        return false;
    }
}
