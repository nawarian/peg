<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Not;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;

it('Should match all', function (Not $not, string $text, string $expected) {
    expect($not->match($text))->toEqual(new Span($expected));
})->with([
    [RuleFactory::not(RuleFactory::literal('a')), 'b', 'b'],
    [RuleFactory::not(RuleFactory::literal('a')), '_', '_'],
]);

it('Should not match any', function (Not $not, string $text) {
    expect($not->match($text))->toBeFalse();
})->with([
    [RuleFactory::not(RuleFactory::literal('a')), 'a']
]);
