<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Pattern;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

it('Should match all', function (Pattern $pattern, string $text) {
    expect($pattern->match($text))->toEqual(new Token('Pattern', new Span($text)));
})->with([
    [RuleFactory::pattern('Name:? Nic[hk]?olas'), 'Name Nicolas'],
]);

it('Should error if pattern is invalid', function (Pattern $pattern) {
    $pattern->match('');
})->throws(ErrorException::class)->with([
    RuleFactory::pattern('??'),
]);
