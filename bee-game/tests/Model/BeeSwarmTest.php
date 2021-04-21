<?php

declare(strict_types=1);

namespace Tests\Model;

use BeeGame\Model\BeeSwarm;
use PHPUnit\Framework\TestCase;

class BeeSwarmTest extends TestCase
{
    private BeeSwarm $swarm;

    public function testAllBeesDieWhenTheQueenDies(): void
    {
        $aliveBees = $this->swarm->getAliveBeesGroupedByType();
        $queen = $aliveBees['Queen'][0];

        // hitting the bee 13 times should kill it (13 * 8 = 104 > 100)
        for ($i = 0; $i < 13; $i++) {
            $queen->acceptHit();
        }

        self::assertEquals([], $this->swarm->getAliveBeesGroupedByType());
    }

    public function testGetAliveMembersGroupedByType(): void
    {
        $aliveBess = $this->swarm->getAliveBeesGroupedByType();

        // initially all bees are alive
        self::assertCount(3, $aliveBess);
        self::assertCount(1, $aliveBess['Queen']);
        self::assertCount(5, $aliveBess['Worker']);
        self::assertCount(8, $aliveBess['Drone']);
    }

    public function testKillAll(): void
    {
        $this->swarm->killAll();

        self::assertFalse($this->swarm->containsAliveBees());
    }

    public function testContainsAliveBees(): void
    {
        self::assertTrue($this->swarm->containsAliveBees());
    }

    public function testGetIterator(): void
    {
        $swarmIterator = $this->swarm->getIterator();
        $groupedBees = $this->swarm->getAliveBeesGroupedByType();
        $expectedBees = array_merge(
            $groupedBees['Queen'],
            $groupedBees['Worker'],
            $groupedBees['Drone']
        );

        self::assertSame($expectedBees, iterator_to_array($swarmIterator));
    }

    protected function setUp(): void
    {
        $this->swarm = new BeeSwarm();
    }
}
