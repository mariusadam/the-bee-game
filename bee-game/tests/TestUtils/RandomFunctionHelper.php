<?php

declare(strict_types=1);

namespace Tests\TestUtils {

    class RandomFunctionHelper
    {
        public static ?\Closure $mtRandCallback;

        public static function getMtRandCallback(): ?\Closure
        {
            return self::$mtRandCallback;
        }
    }
}

/**
 * Define the function in the namespace where it's used to that
 * this will be called instead of the actual function
 */

namespace BeeGame\Util {

    use Tests\TestUtils\RandomFunctionHelper;

    function mt_rand(int $min, int $max): int
    {
        return RandomFunctionHelper::getMtRandCallback()($min, $max);
    }
}
