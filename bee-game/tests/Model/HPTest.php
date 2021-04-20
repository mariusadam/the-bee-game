<?php

declare(strict_types=1);

namespace Tests\Model;

use BeeGame\Model\HP;
use PHPUnit\Framework\TestCase;

class HPTest extends TestCase
{
    /**
     * @dataProvider fromValueThrowsInvalidArgumentExceptionForInvalidValueProvider
     */
    public function testFromValueThrowsInvalidArgumentExceptionForInvalidValue(int $value): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid health points, must be a value within [0,100] interval.');
        HP::fromValue($value);
    }

    public function fromValueThrowsInvalidArgumentExceptionForInvalidValueProvider(): iterable
    {
        yield 'for negative value' => [-1];
        yield 'for value greater than 100' => [101];
    }

    public function testToString(): void
    {
        self::assertSame('13HP', (string)HP::fromValue(13));
    }
}
