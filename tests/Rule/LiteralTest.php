<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Literal;
use Nawarian\PEG\Rule\RuleFactory;

it('Should match all', function (Literal $literal, string $text) {
    expect($literal->match($text))->toBeTrue();
})->with([
    [RuleFactory::literal('Nome: Níckolas'), 'Nome: Níckolas'],
]);

it('Should not match all', function (Literal $literal, string $text) {
    expect($literal->match($text))->toBeFalse();
})->with([
    [RuleFactory::literal('Nome: Níckolas'), 'Nome: Nawarian'],
]);
