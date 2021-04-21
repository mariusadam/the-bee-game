<?php

declare(strict_types=1);

namespace Tests\Model;

use BeeGame\Exception\GameOverException;
use BeeGame\Util\RandomPicker;
use BeeGame\Model\Bee;
use BeeGame\Model\BeeSwarm;
use BeeGame\Model\Game;
use BeeGame\Model\HP;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testGetPlayerName(): void
    {
        $playerName = 'test-player-name';
        $game = new Game($playerName, $this->createMock(BeeSwarm::class));

        self::assertSame($playerName, $game->getPlayerName());
    }

    public function testHitBee(): void
    {
        $inflictedDamage = HP::fromValue(13);
        $bee = $this->createMock(Bee::class);
        $bee
            ->expects(self::once())
            ->method('acceptHit')
            ->willReturn($inflictedDamage);
        $bee
            ->method('getType')
            ->willReturn('TestType');

        $aliveBees = ['test' => [$bee]];
        $swarm = $this->createMock(BeeSwarm::class);
        $swarm->method('containsAliveBees')->willReturn(true);
        $swarm->method('getAliveBeesGroupedByType')->willReturn($aliveBees);

        $beePicker = $this->createMock(RandomPicker::class);
        $beePicker
            ->method('pick')
            ->with($aliveBees)
            ->willReturn($bee);

        $game = new Game('test', $swarm);
        $game->hitBee($beePicker);

        $hitResult = $game->getLastHitResult();
        self::assertNotNull($hitResult);
        self::assertSame($bee, $hitResult->getBee());
        self::assertSame($inflictedDamage, $hitResult->getInflictedDamage());
    }

    public function testGetLastHitReturnsNullWhenBeesWereNeverHit(): void
    {
        $game = new Game('test', $this->createMock(BeeSwarm::class));

        self::assertNull($game->getLastHitResult());
    }

    public function testHitBeeThrowsGameOverExceptionWhenThereNoAliveBeesInTheSwarmAfterHit(): void
    {
        $this->expectException(GameOverException::class);

        $swarm = $this->createMock(BeeSwarm::class);
        $swarm->method('containsAliveBees')->willReturn(false);
        $game = new Game('test', $swarm);

        $picker = $this->createMock(RandomPicker::class);
        $picker->method('pick')->willReturn($this->createMock(Bee::class));

        $game->hitBee($picker);
    }

    public function testHitBeeThrowsGameOverExceptionWhenPickerThrowsException(): void
    {
        $this->expectException(GameOverException::class);

        $swarm = $this->createMock(BeeSwarm::class);
        $game = new Game('test', $swarm);

        $picker = $this->createMock(RandomPicker::class);
        $picker
            ->expects(self::once())
            ->method('pick')
            ->willThrowException(new \InvalidArgumentException());

        $game->hitBee($picker);
    }

    public function testGetSwarm(): void
    {
        $swarm = $this->createMock(BeeSwarm::class);
        $game = new Game('test', $swarm);

        self::assertSame($swarm, $game->getSwarm());
    }

    public function testWasLastTimeHit(): void
    {
        $swarm = $this->createMock(BeeSwarm::class);
        $swarm->method('containsAliveBees')->willReturn(true);
        $game = new Game('test', $swarm);

        $bee = $this->createMock(Bee::class);
        $picker = $this->createMock(RandomPicker::class);
        $picker->method('pick')->willReturn($bee);

        // not yet hit
        self::assertFalse($game->wasHitLastTime($bee));

        $game->hitBee($picker);

        self::assertTrue($game->wasHitLastTime($bee));

        $otherBee = $this->createMock(Bee::class);
        self::assertFalse($game->wasHitLastTime($otherBee));
    }
}
