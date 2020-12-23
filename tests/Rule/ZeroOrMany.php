<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Rule\ZeroOrMany;
use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

it('Should match always', function (ZeroOrMany $zeroOrMany, string $text, string $expected) {
    expect($zeroOrMany->match($text))->toEqual(new Token('ZeroOrMany', new Span($expected)));
})->with([
    [
        RuleFactory::zeroOrMany(
            RuleFactory::pattern('\w+\d{2}\s'),
        ),
        'Nickolas10 Nawarian20 Daniel DaSilva200',
        'Nickolas10 Nawarian20 ',
    ]
]);
