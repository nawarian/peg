<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

final class RuleFactory
{
    public static function pattern(string $pattern): Pattern
    {
        return new Pattern($pattern);
    }

    public static function sequence(Rule ...$rules): Sequence
    {
        return new Sequence($rules);
    }
}
