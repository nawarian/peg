<?php

declare(strict_types=1);

use Nawarian\PEG\Parser;
use Nawarian\PEG\Rule\RuleFactory;
use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

it('Should pick rules properly from Grammar', function () {
    $simpleSumGrammar = <<<GRAMMAR
        Digit       <-  [0-9]
        EndOfFile   <-  !.
        Sum         <-  Digit+ "+" Digit+ EndOfFile
    GRAMMAR;
    $parser = Parser::fromGrammar($simpleSumGrammar);

    expect($parser->rules)->toHaveCount(3);

    $digit = RuleFactory::pattern('[0-9]');
    $endOfFile = RuleFactory::not(RuleFactory::any());

    expect($parser->rules['Digit'])->toEqual($digit);
    expect($parser->rules['EndOfFile'])->toEqual($endOfFile);
    expect($parser->rules['Sum'])->toEqual(
        RuleFactory::sequence(
            RuleFactory::oneOrMany(RuleFactory::named('Digit', $parser)),
            RuleFactory::literal('+'),
            RuleFactory::oneOrMany(RuleFactory::named('Digit', $parser)),
            RuleFactory::named('EndOfFile', $parser),
        ),
    );
});

it('Should fetch matched strings by named rules', function () {
    $simpleSumGrammar = <<<GRAMMAR
        Digit       <-  [0-9]
        EndOfFile   <-  !.
        Sum         <-  Digit+ "+" Digit+ EndOfFile
    GRAMMAR;

    $parser = Parser::fromGrammar($simpleSumGrammar);
    $rootToken = $parser->parse('10+20', 'Sum');

    expect($rootToken)->toEqual(
        new Token('Sum', [
            new Token('Digit', new Span('10')),
            new Token('Literal', new Span('+')),
            new token('Digit', new Span('20')),
            new Token('EndOfFile', new Span(''))
        ])
    );
});
