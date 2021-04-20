<?php

declare(strict_types=1);

namespace Tests\Http;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Router;
use BeeGame\Http\Route;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    private ControllerInterface $firstController;
    private ControllerInterface $secondController;
    private ControllerInterface $thirdController;
    private ControllerInterface $defaultController;

    protected function setUp(): void
    {
        $this->firstController = $this->createMock(ControllerInterface::class);
        $this->secondController = $this->createMock(ControllerInterface::class);
        $this->thirdController = $this->createMock(ControllerInterface::class);
        $this->defaultController = $this->createMock(ControllerInterface::class);

        $this->router = new Router(
            [
                new Route('GET', '/test', $this->firstController),
                new Route('POST', '/another/test/path', $this->secondController),
                new Route('GET', '/', $this->thirdController)
            ],
            $this->defaultController
        );
    }

    public function testMatchReturnsFirstControllerThatCanHandleTheRequest(): void
    {
        self::assertSame($this->firstController, $this->invokeMatch('GET', '/test/'));
        self::assertSame($this->secondController, $this->invokeMatch('POST', '/another/test/path'));
    }

    public function testMatchReturnsDefaultControllerWhenThereIsNoMatch(): void
    {
        self::assertSame($this->defaultController, $this->invokeMatch('GET', '/no-match'));
    }

    public function testCanMatchRootPath(): void
    {
        self::assertSame($this->thirdController, $this->invokeMatch('GET', '/'));
    }

    private function invokeMatch(string $method, string $path): ControllerInterface
    {
        return $this->router->match(new Request($method, $path));
    }
}
