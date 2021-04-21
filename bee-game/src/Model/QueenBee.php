<?php

declare(strict_types=1);

namespace BeeGame\Model;

class QueenBee extends Bee
{
    private BeeSwarm $swarm;

    public function __construct(BeeSwarm $swarm)
    {
        parent::__construct(HP::fromValue(100));
        $this->swarm = $swarm;
    }

    public function getType(): string
    {
        return 'Queen';
    }

    protected function whenDead(): void
    {
        $this->swarm->killAll();
    }

    protected function getDamagePerHit(): HP
    {
        return HP::fromValue(8);
    }
}
