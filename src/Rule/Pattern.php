<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

final class Pattern implements Rule
{
    /**
     * @var string
     */
    public $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function match(string $text): bool
    {
        return preg_match("#{$this->pattern}#", $text) === 1;
    }
}