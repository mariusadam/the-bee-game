<?php

declare(strict_types=1);

namespace BeeGame\Model;

/**
 * Value object representing health points
 */
class HP
{
    private const MIN = 0;
    private const MAX = 100;

    private int $value;

    private function __construct(int $value)
    {
        if ($value < self::MIN || $value > self::MAX) {
            $message = sprintf(
                'Invalid health points, must be a value within [%d,%d] interval.',
                self::MIN,
                self::MAX
            );

            throw new \InvalidArgumentException($message);
        }

        $this->value = $value;
    }

    public static function fromValue(int $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return sprintf('%dHP', $this->value);
    }
}
