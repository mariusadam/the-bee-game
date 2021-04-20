<?php

declare(strict_types=1);

namespace BeeGame\Http;

class Request
{
    private string $method;
    private string $path;
    private string $protocolVersion;
    private array $postFields;

    public function __construct(string $method, string $path, string $protocolVersion = '', array $postFields = [])
    {
        $this->method = $method;
        // trim only if not / is the only part of the path
        $this->path = '/' === $path ? $path : rtrim($path, '/');
        $this->protocolVersion = $protocolVersion;
        $this->postFields = $postFields;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function getPostFields(): array
    {
        return $this->postFields;
    }
}
