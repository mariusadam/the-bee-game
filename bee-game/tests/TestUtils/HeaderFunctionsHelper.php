<?php

declare(strict_types=1);

namespace Tests\TestUtils {

    class HeaderFunctionsHelper
    {
        public static array $headers = [];
    }
}

namespace BeeGame\Http {

    use Tests\TestUtils\HeaderFunctionsHelper;

    /**
     * Collects the sent headers in an array for later inspection during tests
     */
    function header(string $header, bool $replace = true, int $responseCode = null): void
    {
        HeaderFunctionsHelper::$headers[] = [
            'header'        => $header,
            'replace'       => $replace,
            'response_code' => $responseCode,
        ];
    }
}