<?php

declare(strict_types=1);

use Nawarian\PEG\Span;

it('Should subtract spans', function (Span $bigger, Span $smaller, Span $expected) {
    expect($bigger->subtract($smaller))->toEqual($expected);
})->with([
    [new Span('Nawarian'), new Span('arian'), new Span('Naw')]
]);
