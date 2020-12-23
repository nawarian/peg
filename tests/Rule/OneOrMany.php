<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\OneOrMany;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

it('Should match all', function (OneOrMany $oneOrMany, string $text, string $expected) {
    expect($oneOrMany->match($text))->toEqual(new Token('OneOrMany', new Span($expected)));
})->with([
    [
        RuleFactory::oneOrMany(
            RuleFactory::pattern('\w+\d{2}\s'),
        ),
        'Nickolas10 Nawarian20 Daniel DaSilva200',
        'Nickolas10 Nawarian20 ',
    ]
]);

it('Should not match any', function (OneOrMany $oneOrMany, string $text) {
    expect($oneOrMany->match($text))->toBeFalse();
})->with([
    [
        RuleFactory::oneOrMany(RuleFactory::pattern('\w+\d{2}\s')),
        'Nickolas Nawarian10',
    ]
]);
