<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

final class Sequence implements Rule
{
    /**
     * @var Rule[]
     */
    public $rules;

    /**
     * @param Rule[] $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }
}
