<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;
use UnexpectedValueException;

trait TokenValueResolver
{
    private function resolveTokenValueAsSpan(Token $matched): Span
    {
        if ($matched->value instanceof Token) {
            if ($matched->value->value instanceof Span) {
                return $matched->value->value;
            }

            return $this->resolveTokenValueAsSpan($matched->value->value);
        }

        if (is_array($matched->value)) {
            $span = new Span('');

            /** @var Token $token */
            foreach ($matched->value as $token) {
                $span = $span->add($this->resolveTokenValueAsSpan($token));
            }

            return $span;
        }

        throw new UnexpectedValueException('This line should never be reached.');
    }
}
