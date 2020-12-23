<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

final class NamedRule implements Rule
{
    /**
     * @var string
     */
    public $namedRule;

    public function __construct(string $namedRule)
    {
        $this->namedRule = $namedRule;
    }

    public function match(string $text)
    {
        throw new \Exception('Not implemented.');
    }
}
