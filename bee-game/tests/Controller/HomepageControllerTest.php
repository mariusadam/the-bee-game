<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Controller\HomepageController;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use BeeGame\Templating\TemplateEngineInterface;
use PHPUnit\Framework\TestCase;

class HomepageControllerTest extends TestCase
{
    private Session $session;
    private TemplateEngineInterface $templateEngine;
    private HomepageController $controller;

    public function testInvoke(): void
    {
        $renderedBody = 'Rendered homepage';
        $this->templateEngine
            ->expects(self::once())
            ->method('render')
            ->with('homepage', [])
            ->willReturn($renderedBody);

        $expected = new Response(200, $renderedBody);
        self::assertEquals($expected, ($this->controller)($this->createMock(Request::class)));
    }

    public function testInvokeRedirectsToPlayWhenGameExistsInSession(): void
    {
        $this->session
            ->method('get')
            ->with('game')
            ->willReturn($this->createMock(Game::class));

        self::assertEquals(
            Response::forRedirectTo('/play'),
            ($this->controller)($this->createMock(Request::class))
        );
    }

    protected function setUp(): void
    {
        $this->session = $this->createMock(Session::class);
        $this->templateEngine = $this->createMock(TemplateEngineInterface::class);
        $this->controller = new HomepageController($this->session, $this->templateEngine);
    }
}
