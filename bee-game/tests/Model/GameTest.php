<?php

declare(strict_types=1);

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use BeeGame\Model\Game;

class GameTest extends TestCase
{
    public function testGetPlayer(): void
    {
        $playerName = 'test-player-name';
        $game = new Game($playerName);

        self::assertSame($playerName, $game->getPlayerName());
    }
}
