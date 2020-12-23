<?php

declare(strict_types=1);

use Nawarian\PEG\Parser;
use Nawarian\PEG\Rule\RuleFactory;

$widestGrammarSpec = <<<GRAMMAR
    PEG         <- .* EndOfFile
    EndOfFile   <-  !.
GRAMMAR;

it('Creates from PEG strings', function (string $grammarSpec) {
    expect(Parser::fromGrammar($grammarSpec))->toBeInstanceOf(Parser::class);
})->with([$widestGrammarSpec]);

it('Generates a grammar composed of rules', function (string $widestGrammarSpec) {
    $parser = Parser::fromGrammar($widestGrammarSpec);

    expect($parser->rules)->toHaveCount(2);

    $endOfFile = RuleFactory::pattern('!.');

    expect($parser->rules['PEG'])->toEqual(
        RuleFactory::sequence(
            RuleFactory::pattern('.*'),
            $endOfFile,
        ),
    );
    expect($parser->rules['EndOfFile'])->toEqual($endOfFile);
})->with([$widestGrammarSpec]);
