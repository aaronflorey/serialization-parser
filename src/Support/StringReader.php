<?php

namespace Mochaka\SerializationParser\Support;

use RuntimeException;

class StringReader
{
    protected int $pos = 0;
    protected int $max = 0;

    /** @var string[] */
    protected array $string;

    public function __construct(string $string)
    {
        $this->string = str_split($string);
        $this->max = \strlen($string) - 1;
    }

    /*
     * Read the next character from the supplied string.
     * Return null when we have run out of characters.
     */
    public function readOne(): ?string
    {
        if ($this->pos <= $this->max) {
            $value = $this->string[$this->pos];
            ++$this->pos;

            return $value;
        }

        return null;
    }

    public function readRequiredChar(string ...$chars): void
    {
        $one = $this->readOne();
        if (!\in_array($one, $chars)) {
            throw new RuntimeException(\sprintf('Expected character: %s, got %s', implode(' ', $chars), $one));
        }
    }

    public function rewind(int $count = 1): void
    {
        $this->pos -= $count;
        $this->pos = max($this->pos, 0);
    }

    /*
     * Read characters until we reach the given character $char.
     * By default, discard that final matching character and return
     * the rest.
     */
    public function readUntil(string $char, bool $discardChar = true): string
    {
        $value = '';

        while (null !== ($one = $this->readOne())) {
            if ($one !== $char || !$discardChar) {
                $value .= $one;
            }

            if ($one === $char) {
                break;
            }
        }

        return $value;
    }

    /*
     * Read $count characters, or until we have reached the end, whichever comes first.
     * By default, remove enclosing double-quotes from the result.
     */
    public function read(int $count = 1, bool $stripQuotes = true): string
    {
        $value = '';

        while ($count > 0 && null != ($one = $this->readOne())) {
            $value .= $one;
            --$count;
        }

        return $stripQuotes ? $this->stripQuotes($value) : $value;
    }

    /*
     * Remove a single set of double-quotes from around a string.
     *  abc => abc
     *  "abc" => abc
     *  ""abc"" => "abc"
     */
    public function stripQuotes(string $string): string
    {
        // Only remove exactly one quote from the start and the end,
        // and then only if there is one at each end.

        if (\strlen($string) < 2 || !str_starts_with($string, '"') || !str_ends_with($string, '"')) {
            // Too short, or does not start or end with a quote.
            return $string;
        }

        // Return the middle of the string, from the second character to the second-but-last.
        return substr($string, 1, -1);
    }
}
