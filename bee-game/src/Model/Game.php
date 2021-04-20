<?php

declare(strict_types=1);

namespace BeeGame\Model;

class Game
{
    private string $playerName;

    public function __construct(string $playerName)
    {
        $this->playerName = $playerName;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }
}
