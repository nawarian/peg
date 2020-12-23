<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;
use Nawarian\PEG\Token;

final class Literal implements Rule
{
    private const TOKEN_NAME = 'Literal';

    /**
     * @var string
     */
    public $literal;

    public function __construct(string $literal)
    {
        $this->literal = $literal;
    }

    public function match(string $text)
    {
        if (str_starts_with($text, $this->literal)) {
            return new Token(self::TOKEN_NAME, new Span($this->literal));
        }

        return false;
    }
}
