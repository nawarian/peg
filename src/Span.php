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

    private $pos = 0;

    public function __construct(string $input)
    {
        $this->stream = $input;
        $this->len = mb_strlen($input);
    }

    public function add(Span $span): self
    {
        return new self($this->stream . $span->stream);
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

        return new self($newStream);
    }

    public function reset(): void
    {
        $this->pos = 0;
    }

    public function current(): ?string
    {
        return $this->stream[$this->pos] ?? null;
    }

    public function peek(): ?string
    {
        return $this->stream[$this->pos + 1] ?? null;
    }

    public function next(): ?string
    {
        return $this->stream[++$this->pos] ?? null;
    }

    public function read(int $length): string
    {
        $str = '';

        for ($i = 0; $i < $length; ++$i) {
            $str .= $this->current();
            $this->next();
        }

        return $str;
    }

    public function readLine(): string
    {
        $line = '';

        while ($chr = $this->peek()) {
            if ($chr === PHP_EOL) {
                $this->next();
                break;
            }

            $line .= $this->next();
        }

        return $line;
    }

    public function readUntilEOF(bool $restoreCursor = false): string
    {
        $oldPos = $this->pos;
        $str = $this->current();

        while ($this->next()) {
            $str .= $this->current();
        }

        if ($restoreCursor) {
            $this->pos = $oldPos;
        }

        return $str;
    }
}
