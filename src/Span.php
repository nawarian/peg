<?php

declare(strict_types=1);

namespace Nawarian\PEG;

final class Span
{
    /**
     * @var string
     */
    public $stream;

    public $len = 0;

    public function __construct(string $input)
    {
        $this->stream = $input;
        $this->len = mb_strlen($input);
    }

    public function subtract(Span $span): self
    {
        if (str_contains($this->stream, $span->stream) === false) {
            return $this;
        }

        /**
         * @todo -> make it multibyte safe
         */
        $newStream = str_replace($span->stream, '', $this->stream);

        return new Span($newStream);
    }
}
