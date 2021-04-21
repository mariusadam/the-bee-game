<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Controller\PlayController;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use BeeGame\Templating\TemplateEngineInterface;
use PHPUnit\Framework\TestCase;

class PlayControllerTest extends TestCase
{
    private Session $session;
    private TemplateEngineInterface $templateEngine;
    private PlayController $controller;

    public function testInvoke(): void
    {
        $game = $this->createMock(Game::class);
        $lastMessage = 'This was last message';
        $this->session
            ->method('get')
            ->with('game')
            ->willReturn($game);
        $this->session
            ->method('getAndRemove')
            ->with('lastMessage')
            ->willReturn($lastMessage);
        $renderedBody = 'Rendered game';
        $this->templateEngine
            ->expects(self::once())
            ->method('render')
            ->with('game', ['game' => $game, 'lastMessage' => $lastMessage])
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

    protected function setUp(): void
    {
        $this->session = $this->createMock(Session::class);
        $this->templateEngine = $this->createMock(TemplateEngineInterface::class);
        $this->controller = new PlayController($this->session, $this->templateEngine);
    }
}
