<?php

declare(strict_types=1);

namespace Tests\Model;

use PHPUnit\Framework\TestCase;
use BeeGame\Model\BeeSwarm;

class BeeSwarmTest extends TestCase
{
    public function testConstruct(): void
    {
        $swarm = new BeeSwarm();
        self::assertNotNull($swarm);
    }
}
