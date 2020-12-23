<?php

declare(strict_types=1);

use Nawarian\PEG\Parser;
use Nawarian\PEG\Rule\RuleFactory;

$widestGrammarSpec = <<<GRAMMAR
    # The PEG rule matches ANYTHING until EOF is found.
    PEG         <- .* EndOfFile
    EndOfFile   <-  !.
GRAMMAR;

it('Creates from PEG strings', function (string $grammarSpec) {
    expect(Parser::fromGrammar($grammarSpec))->toBeInstanceOf(Parser::class);
})->with([$widestGrammarSpec]);

it('Generates a grammar composed of rules', function (string $widestGrammarSpec) {
    $parser = Parser::fromGrammar($widestGrammarSpec);

    expect($parser->rules)->toHaveCount(2);

    $endOfFile = RuleFactory::not(RuleFactory::any());

    expect($parser->rules['PEG'])->toEqual(
        RuleFactory::sequence(
            RuleFactory::zeroOrMany(
                RuleFactory::any()
            ),
            RuleFactory::named('EndOfFile', $parser),
        ),
    );
    expect($parser->rules['EndOfFile'])->toEqual($endOfFile);
})->with([$widestGrammarSpec]);
