<?php

declare(strict_types=1);

namespace Tests\Factory;

use BeeGame\Model\Game;
use PHPUnit\Framework\TestCase;
use BeeGame\Factory\GameFactory;

class GameFactoryTest extends TestCase
{
    public function testCreateNewGame(): void
    {
        $factory = new GameFactory();
        $playerName = 'The test';
        $expectedGame = new Game(
            $playerName
        );
        self::assertEquals($expectedGame, $factory->createNewGame($playerName));
    }
}
