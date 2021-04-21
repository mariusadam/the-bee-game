<?php

declare(strict_types=1);

namespace Tests\Http;

use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Kernel;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Router;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    private Kernel $kernel;
    private Router $router;

    public function testHandle(): void
    {
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $response
            ->expects(self::once())
            ->method('prepare')
            ->with($request);
        $controller = $this->createMock(ControllerInterface::class);
        $controller
            ->expects(self::once())
            ->method('__invoke')
            ->with($request)
            ->willReturn($response);
        $this->router->method('match')->willReturn($controller);

        self::assertSame($response, $this->kernel->handle($request));
    }

    protected function setUp(): void
    {
        $this->router = $this->createMock(Router::class);
        $this->kernel = new Kernel($this->router);
    }
}
