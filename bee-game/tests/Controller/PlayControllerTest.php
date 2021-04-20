<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use PHPUnit\Framework\TestCase;
use BeeGame\Controller\PlayController;
use BeeGame\Templating\TemplateEngineInterface;

class PlayControllerTest extends TestCase
{
    private Session $session;
    private TemplateEngineInterface $templateEngine;
    private PlayController $controller;

    protected function setUp(): void
    {
        $this->session = $this->createMock(Session::class);
        $this->templateEngine = $this->createMock(TemplateEngineInterface::class);
        $this->controller = new PlayController($this->session, $this->templateEngine);
    }

    public function testInvoke(): void
    {
        $game = $this->createMock(Game::class);
        $this->session
            ->method('get')
            ->with('game')
            ->willReturn($game);
        $renderedBody = 'Rendered game';
        $this->templateEngine
            ->expects(self::once())
            ->method('render')
            ->with('game', ['game' => $game])
            ->willReturn($renderedBody);

        $expected = new Response(200, $renderedBody);
        self::assertEquals($expected, ($this->controller)($this->createMock(Request::class)));
    }

    public function testInvokeRedirectsToHomepageGameIsNotFound(): void
    {
        $this->session
            ->method('get')
            ->with('game')
            ->willReturn(null);

        self::assertEquals(Response::forRedirectTo('/'), ($this->controller)($this->createMock(Request::class)));
    }
}
