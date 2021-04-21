<?php

declare(strict_types=1);

namespace BeeGame\Controller;

use BeeGame\Factory\GameFactory;
use BeeGame\Http\ControllerInterface;
use BeeGame\Http\Request;
use BeeGame\Http\Response;
use BeeGame\Http\Session;

class NewGameController implements ControllerInterface
{
    private GameFactory $gameFactory;
    private Session $session;

    public function __construct(GameFactory $gameFactory, Session $session)
    {
        $this->gameFactory = $gameFactory;
        $this->session = $session;
    }

    public function __invoke(Request $request): Response
    {
        $playerName = $request->getPostFields()['playerName'] ?? 'No name';

        $game = $this->gameFactory->createNewGame($playerName);
        $this->session->set('game', $game);

        return Response::forRedirectTo('/play');
    }
}
