<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Literal;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;

it('Should match all', function (Literal $literal, string $text) {
    expect($literal->match($text))->toEqual(new Span('Nome: Níckolas'));
})->with([
    [RuleFactory::literal('Nome: Níckolas'), 'Nome: Níckolas'],
]);

it('Should not match all', function (Literal $literal, string $text) {
    expect($literal->match($text))->toBeFalse();
})->with([
    [RuleFactory::literal('Nome: Níckolas'), 'Nome: Nawarian'],
]);
