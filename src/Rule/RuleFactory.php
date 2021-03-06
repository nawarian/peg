<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Parser;

final class RuleFactory
{
    public static function any(): Any
    {
        return new Any();
    }

    public static function literal(string $literal): Literal
    {
        return new Literal($literal);
    }

    public static function named(string $namedRule, Parser $parser): NamedRule
    {
        return new NamedRule($namedRule, $parser);
    }

    public static function not(Rule $rule): Not
    {
        return new Not($rule);
    }

    public static function oneOrMany(Rule $rule): OneOrMany
    {
        return new OneOrMany($rule);
    }

    public static function pattern(string $pattern): Pattern
    {
        return new Pattern($pattern);
    }

    public static function sequence(Rule ...$rules): Sequence
    {
        return new Sequence($rules);
    }

    public static function zeroOrMany(Rule $rule): ZeroOrMany
    {
        return new ZeroOrMany($rule);
    }
}
