<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Rule\ZeroOrMany;
use Nawarian\PEG\Span;

it('Should match always', function (ZeroOrMany $zeroOrMany, string $text, string $expected) {
    expect($zeroOrMany->match($text))->toEqual(new Span($expected));
})->with([
    [
        RuleFactory::zeroOrMany(
            RuleFactory::pattern('\w+\d{2}\s'),
        ),
        'Nickolas10 Nawarian20 Daniel DaSilva200',
        'Nickolas10 Nawarian20 ',
    ]
]);
