<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Exception\GameOverException;
use BeeGame\Factory\GameFactory;
use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;
use BeeGame\Model\Game;
use BeeGame\Util\RandomPicker;

class HitBeeController implements ControllerInterface
{
    private Session $session;
    private RandomPicker $randomPicker;
    private GameFactory $gameFactory;

    public function __construct(Session $session, RandomPicker $randomPicker, GameFactory $gameFactory)
    {
        $this->session = $session;
        $this->randomPicker = $randomPicker;
        $this->gameFactory = $gameFactory;
    }

    public function __invoke(Request $request): Response
    {
        $game = $this->getGame();
        try {
            $game->hitBee($this->randomPicker);
        } catch (GameOverException $ex) {
            $newGame = $this->gameFactory->createNewGame($game->getPlayerName());
            $this->session->set('game', $newGame);
            $this->session->set('lastMessage', 'The previous game finished, a new one has been created.');
        }

        return Response::forRedirectTo('/play');
    }

    private function getGame(): Game
    {
        return $this->session->get('game');
    }
}
