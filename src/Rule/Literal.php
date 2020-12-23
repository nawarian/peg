<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

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

    public function match(string $text): bool
    {
        return $text === $this->literal;
    }
}
