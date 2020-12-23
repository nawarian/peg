<?php

declare(strict_types=1);

namespace Nawarian\PEG;

final class Token
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $value;

    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
