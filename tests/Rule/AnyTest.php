<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Any;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

it('Should match all', function (Any $any, string $char, string $expectedChar) {
    expect($any->match($char))->toEqual(new Token('Any', new Span($expectedChar)));
})->with([
    [RuleFactory::any(), 'N', 'N'],
    [RuleFactory::any(), '0', '0'],
    [RuleFactory::any(), '-', '-'],
    [RuleFactory::any(), '.', '.'],
    [RuleFactory::any(), '$', '$'],
    [RuleFactory::any(), PHP_EOL, PHP_EOL],
]);

it('Should fail if matching string is empty', function (Any $any) {
    expect($any->match(''))->toBeFalse();
})->with([RuleFactory::any()]);
