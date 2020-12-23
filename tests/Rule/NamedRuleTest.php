<?php

declare(strict_types=1);

use Nawarian\PEG\Parser;
use Nawarian\PEG\Rule\NamedRule;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;

$widestGrammarSpec = <<<GRAMMAR
    PEG         <- .* EndOfFile
    EndOfFile   <- !.
GRAMMAR;

$widestGrammar = Parser::fromGrammar($widestGrammarSpec);

it('Should match all', function (NamedRule $namedRule) {
    expect($namedRule->match(''))->toEqual(new Span(''));
})->with([
    [RuleFactory::named('EndOfFile', $widestGrammar)],
]);
