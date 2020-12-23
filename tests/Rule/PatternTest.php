<?php

declare(strict_types=1);

use Nawarian\PEG\Rule\Pattern;
use Nawarian\PEG\Rule\RuleFactory;

it('Should match all', function (Pattern $pattern, string $text) {
    expect($pattern->match($text))->toBeTrue();
})->with([
    [RuleFactory::pattern('Name:? Nic[hk]?olas'), 'Name Nicolas'],
]);

it('Should error if pattern is invalid', function (Pattern $pattern) {
    $pattern->match('');
})->throws(ErrorException::class)->with([
    RuleFactory::pattern('??'),
]);
