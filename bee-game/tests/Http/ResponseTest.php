<?php

declare(strict_types=1);

namespace Tests\Http;

use BeeGame\Http\Request;
use BeeGame\Http\Response;
use PHPUnit\Framework\TestCase;
use Tests\TestUtils\HeaderFunctionsHelper;

class ResponseTest extends TestCase
{
    protected function setUp(): void
    {
        // clean up the headers that might have been collected so far
        HeaderFunctionsHelper::$headers = [];
    }

    public function testSend(): void
    {
        $body = 'This is the response body';
        $this->expectOutputString($body);

        $response = new Response(404, $body);
        $response->prepare(new Request('', ''));
        $response->send();

        $expectedHeaders = [
            [
                'header' => 'HTTP/1.0 404 Not Found',
                'replace' => true,
                'response_code' => 404
            ]
        ];

        self::assertSame($expectedHeaders, HeaderFunctionsHelper::$headers);
    }

    public function testPrepareFixesProtocolVersion(): void
    {
        $response = new Response(123, '');
        $response->prepare(new Request('', '', 'HTTP/1.1'));
        $response->send();
        $expectedHeaders = [
            [
                'header' => 'HTTP/1.1 123 Unknown Status',
                'replace' => true,
                'response_code' => 123
            ]
        ];

        self::assertSame($expectedHeaders, HeaderFunctionsHelper::$headers);
    }

    public function testForRedirectTo(): void
    {
        $response = Response::forRedirectTo('/test/redirect');
        $response->send();
        $expectedHeaders = [
            [
                'header' => 'Location: /test/redirect',
                'replace' => true,
                'response_code' => 302
            ],
            [
                'header' => 'HTTP/1.0 302 Found',
                'replace' => true,
                'response_code' => 302
            ]
        ];

        self::assertSame($expectedHeaders, HeaderFunctionsHelper::$headers);
    }
}
