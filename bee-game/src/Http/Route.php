<?php

declare(strict_types=1);

namespace BeeGame\Http;

class Route
{
    private string $method;
    private string $path;
    private ControllerInterface $controller;

    public function __construct(string $method, string $path, ControllerInterface $controller)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
    }

    public function getController(): ControllerInterface
    {
        return $this->controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
