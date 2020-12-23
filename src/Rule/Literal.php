<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class Literal implements Rule
{
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
            return new Span($this->literal);
        }

        return false;
    }
}
