<?php

declare(strict_types=1);

namespace Tests\Controller;

use BeeGame\Controller\HitBeeController;
use BeeGame\Exception\GameOverException;
use BeeGame\Factory\GameFactory;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use BeeGame\Util\RandomPicker;
use PHPUnit\Framework\TestCase;

class HitBeeControllerTest extends TestCase
{
    private Session $session;
    private RandomPicker $randomPicker;
    private GameFactory $gameFactory;
    private HitBeeController $controller;

    public function testInvokeCallsHitBeeOnTheGame(): void
    {
        $request = $this->createMock(Request::class);

        $game = $this->createMock(Game::class);
        $game
            ->expects(self::once())
            ->method('hitBee')
            ->with($this->randomPicker);
        $this->session
            ->method('get')
            ->willReturn($game);

        $expected = Response::forRedirectTo('/play');
        self::assertEquals($expected, ($this->controller)($request));
    }

    public function testInvokeHandlesGameOverException(): void
    {
        $game = $this->createMock(Game::class);
        $game
            ->method('hitBee')
            ->willThrowException(new GameOverException());
        $this->session
            ->method('get')
            ->willReturn($game);

        $newGame = $this->createMock(Game::class);
        $this->gameFactory
            ->method('createNewGame')
            ->willReturn($newGame);
        $this->session
            ->expects(self::exactly(2))
            ->method('set')
            ->withConsecutive(
                ['game', $newGame],
                ['lastMessage', 'The previous game finished, a new one has been created.']
            );

        ($this->controller)($this->createMock(Request::class));
    }

    protected function setUp(): void
    {
        $this->session = $this->createMock(Session::class);
        $this->randomPicker = $this->createMock(RandomPicker::class);
        $this->gameFactory = $this->createMock(GameFactory::class);
        $this->controller = new HitBeeController($this->session, $this->randomPicker, $this->gameFactory);
    }
}
