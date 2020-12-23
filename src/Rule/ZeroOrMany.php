<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Span;

final class ZeroOrMany implements Rule
{
    /**
     * @var Rule
     */
    public $rule;

    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    public function match(string $text)
    {
        throw new \Exception('Not implemented.');
    }
}
