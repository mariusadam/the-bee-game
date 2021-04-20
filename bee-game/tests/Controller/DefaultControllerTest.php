<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Http\Request;
use BeeGame\Http\Response;
use PHPUnit\Framework\TestCase;
use BeeGame\Controller\DefaultController;
use BeeGame\Templating\TemplateEngineInterface;

class DefaultControllerTest extends TestCase
{
    private DefaultController $controller;
    private TemplateEngineInterface $templateEngine;

    protected function setUp(): void
    {
        $this->templateEngine = $this->createMock(TemplateEngineInterface::class);
        $this->controller = new DefaultController($this->templateEngine);
    }

    public function testInvoke(): void
    {
        $request = $this->createMock(Request::class);
        $renderedBody = 'Rendered response body';
        $this->templateEngine
            ->expects(self::once())
            ->method('render')
            ->with('not-found', ['request' => $request])
            ->willReturn($renderedBody);

        $expected = new Response(404, $renderedBody);
        self::assertEquals($expected, ($this->controller)($request));
    }
}
