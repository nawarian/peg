<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Rule\Sequence;
use Nawarian\PEG\Span;

it('Should match all', function (Sequence $sequence, string $text) {
    expect($sequence->match($text))->toEqual(new Span('Nome: Nickolas'));
})->with([
    [
        RuleFactory::sequence(
            RuleFactory::literal('Nome: '),
            RuleFactory::pattern('\w+'),
        ),
        'Nome: Nickolas'
    ],
]);

it('Should not match all', function (Sequence $sequence, string $text) {
    expect($sequence->match($text))->toBeFalse();
})->with([
    [
        RuleFactory::sequence(
            RuleFactory::literal('Nome: '),
            RuleFactory::pattern('\w+'),
        ),
        'Name: Nickolas'
    ],
]);
