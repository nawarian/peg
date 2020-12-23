<?php

declare(strict_types=1);

namespace Nawarian\PEG\Rule;

use Nawarian\PEG\Token;

interface Rule
{
    /**
     * Returns a matched span or false in case of non-match
     *
     * @param string $text
     * @return Token|false
     */
    public function match(string $text);
}
