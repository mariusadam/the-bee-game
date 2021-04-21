<?php

declare(strict_types=1);

namespace Tests\Util;

use BeeGame\Util\RandomPicker;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils\RandomFunctionHelper;

class RandomPickerTest extends TestCase
{
    private RandomPicker $picker;

    public function testPick(): void
    {
        $callCount = 0;
        RandomFunctionHelper::$mtRandCallback = function (int $min, int $max) use (&$callCount): int {
            $callCount++;
            self::assertEquals(0, $min);

            if (1 === $callCount) {
                self::assertEquals(2, $max);

                return 1;
            }
            if (2 === $callCount) {
                self::assertEquals(4, $max);

                return 2;
            }

            throw new \Exception('Unexpected call');
        };

        $values = [
            'partition_1' => [0],
            'partition_2' => [10, 20, 30, 50, 100],
            'partition_3' => [6, 2, 3, 4],
        ];

        self::assertEquals(30, $this->picker->pick($values));
    }

    public function testPickWithNoGroups(): void
    {
        $this->expectExceptionMessage('Groups list cannot be empty.');

        $this->picker->pick([]);
    }

    public function testPickWithNoValueWithinGroup(): void
    {
        RandomFunctionHelper::$mtRandCallback = fn(int $min, int $max) => 0;

        $this->expectExceptionMessage('At least one value must be present in a group.');

        $this->picker->pick(['test' => []]);
    }

    protected function setUp(): void
    {
        $this->picker = new RandomPicker();
        RandomFunctionHelper::$mtRandCallback = null;
    }
}
