<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

interface Rule
{
    public function match(string $text): bool;
}
