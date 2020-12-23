<?php

declare(strict_types=1);

namespace Nawarian\PEG;

use Stringable;

final class Span implements Stringable
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
        if (str_contains($this->stream, $span->stream) === false || $span->stream === '') {
            return $this;
        }

        $before = mb_strstr($this->stream, $span->stream, true);
        $pos = mb_strpos($this->stream, $span->stream);
        $after = mb_substr($this->stream, $pos + $span->len);

        return new self($before . $after);
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

        $chr = $this->peek();
        while ($chr !== null) {
            if ($chr === PHP_EOL) {
                $this->next();
                break;
            }

            $line .= $this->next();
            $chr = $this->peek();
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

    public function __toString(): string
    {
        $oldPos = $this->pos;
        $this->pos = 0;

        $str = $this->readUntilEOF();

        $this->pos = $oldPos;
        return $str;
    }
}
