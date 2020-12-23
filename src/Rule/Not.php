<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

final class Not implements Rule
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
