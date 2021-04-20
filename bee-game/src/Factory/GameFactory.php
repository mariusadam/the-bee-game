<?php

declare(strict_types=1);

namespace BeeGame\Factory;

use BeeGame\Model\Game;

class GameFactory
{
    public function createNewGame(string $playerName): Game
    {
        return new Game($playerName);
    }
}
