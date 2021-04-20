<?php

declare(strict_types=1);

namespace BeeGame\Http;

class Response
{
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_OK        = 200;
    public const HTTP_FOUND     = 302;

    private static array $statusCodeToText = [
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_OK        => 'OK',
        self::HTTP_FOUND     => 'Found',
    ];

    private string $body;
    private int $statusCode;
    private string $statusText;
    private string $version = '1.0';
    private array $headers;

    public function __construct(int $statusCode, string $body, array $headers = [])
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->statusText = self::$statusCodeToText[$statusCode] ?? 'Unknown Status';
        $this->headers = $headers;
    }

    public static function forRedirectTo(string $targetUrl): self
    {
        $headers = [sprintf('Location: %s', $targetUrl)];
        return new self(self::HTTP_FOUND, '', $headers);
    }

    /**
     * Sends HTTP headers and body.
     */
    public function send(): void
    {
        // send headers
        foreach ($this->headers as $header) {
            header($header, true, $this->statusCode);
        }

        // send status
        header(sprintf('HTTP/%s %s %s', $this->version, $this->statusCode, $this->statusText), true, $this->statusCode);

        // and finally, the body
        echo $this->body;
    }

    /**
     * Prepares the response before it is sent to the client
     */
    public function prepare(Request $request): void
    {
        if ('HTTP/1.1' === $request->getProtocolVersion()) {
            $this->version = '1.1';
        }
    }
}
