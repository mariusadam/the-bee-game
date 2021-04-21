<?php

declare(strict_types=1);

namespace Tests\Factory;

use BeeGame\Factory\GameFactory;
use PHPUnit\Framework\TestCase;

class GameFactoryTest extends TestCase
{
    public function testCreateNewGame(): void
    {
        $factory = new GameFactory();
        $playerName = 'The test';
        self::assertEquals($playerName, $factory->createNewGame($playerName)->getPlayerName());
    }
}
