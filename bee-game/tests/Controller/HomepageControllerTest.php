<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Http\Request;
use BeeGame\Http\Response;
use PHPUnit\Framework\TestCase;
use BeeGame\Controller\HomepageController;
use BeeGame\Templating\TemplateEngineInterface;

class HomepageControllerTest extends TestCase
{
    private HomepageController $controller;
    private TemplateEngineInterface $templateEngine;

    protected function setUp(): void
    {
        $this->templateEngine = $this->createMock(TemplateEngineInterface::class);
        $this->controller = new HomepageController($this->templateEngine);
    }

    public function testInvoke(): void
    {
        $request = $this->createMock(Request::class);
        $renderedBody = 'Rendered homepage';
        $this->templateEngine
            ->expects(self::once())
            ->method('render')
            ->with('homepage', [])
            ->willReturn($renderedBody);

        $expected = new Response(200, $renderedBody);
        self::assertEquals($expected, ($this->controller)($request));
    }
}
