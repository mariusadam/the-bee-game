<?php

declare(strict_types=1);

namespace Tests\DI;

use BeeGame\DI\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testGetServiceThatUsesParams(): void
    {
        $container = new Container(
            [
                'test_param_name' => 'Test Parameter Value',
            ],
            [
                TestClass::class => fn(Container $container): TestClass => new TestClass(
                    $container->getParameter('test_param_name')
                ),
            ]
        );

        /** @var TestClass $firstInstance */
        $firstInstance = $container->get(TestClass::class);
        self::assertSame($firstInstance, $container->get(TestClass::class));
        self::assertSame('Test Parameter Value', $firstInstance->param);
    }

    public function testGetServiceThatDoesNotHaveAFactory(): void
    {
        $container = new Container([], []);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Service "test_service" is not defined.');

        $container->get('test_service');
    }

    public function testGetParameterThatDoesNotExist(): void
    {
        $container = new Container([], []);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Parameter "test_param" is not defined.');

        $container->getParameter('test_param');
    }
}

class TestClass
{
    public string $param;

    public function __construct(string $param)
    {
        $this->param = $param;
    }
}
