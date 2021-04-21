<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Controller\NewGameController;
use BeeGame\Factory\GameFactory;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use PHPUnit\Framework\TestCase;

class NewGameControllerTest extends TestCase
{
    private GameFactory $gameFactory;
    private Session $session;
    private NewGameController $controller;

    public function testInvoke(): void
    {
        $playerName = 'The player name';
        $request = new Request('', '', '', ['playerName' => $playerName]);

        $game = $this->createMock(Game::class);
        $this->gameFactory
            ->expects(self::once())
            ->method('createNewGame')
            ->with($playerName)
            ->willReturn($game);
        $this->session
            ->expects(self::once())
            ->method('set')
            ->with('game', $game);

        $expected = Response::forRedirectTo('/play');
        self::assertEquals($expected, ($this->controller)($request));
    }

    public function testInvokeWithoutName(): void
    {
        $request = new Request('', '', '', []);

        $game = $this->createMock(Game::class);
        $this->gameFactory
            ->expects(self::once())
            ->method('createNewGame')
            ->with('No name')
            ->willReturn($game);
        $this->session
            ->expects(self::once())
            ->method('set')
            ->with('game', $game);

        $expected = Response::forRedirectTo('/play');
        self::assertEquals($expected, ($this->controller)($request));
    }

    protected function setUp(): void
    {
        $this->gameFactory = $this->createMock(GameFactory::class);
        $this->session = $this->createMock(Session::class);
        $this->controller = new NewGameController($this->gameFactory, $this->session);
    }
}
