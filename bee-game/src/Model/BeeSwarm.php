<?php

declare(strict_types=1);

namespace BeeGame\Model;

class BeeSwarm implements \IteratorAggregate
{
    private const WORKER_BEES_COUNT = 5;
    private const DRONE_BEES_COUNT  = 8;

    /**
     * @var array|Bee[]
     */
    private array $members;

    public function __construct()
    {
        $this->members = [new QueenBee($this)];
        for ($i = 0; $i < self::WORKER_BEES_COUNT; $i++) {
            $this->members[] = new WorkerBee();
        }
        for ($i = 0; $i < self::DRONE_BEES_COUNT; $i++) {
            $this->members[] = new DroneBee();
        }
    }

    public function containsAliveBees(): bool
    {
        return [] !== $this->getAliveBeesGroupedByType();
    }

    /**
     * @return array|Bee[][]
     */
    public function getAliveBeesGroupedByType(): array
    {
        $grouped = [];
        foreach ($this->members as $bee) {
            if ($bee->isDead()) {
                continue;
            }

            $grouped[$bee->getType()][] = $bee;
        }

        return $grouped;
    }

    public function killAll(): void
    {
        foreach ($this->members as $bee) {
            if ($bee->isDead()) {
                continue;
            }

            $bee->die();
        }
    }

    /**
     * @return \Traversable|Bee[]
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->members);
    }
}
