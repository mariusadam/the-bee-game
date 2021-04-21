<?php

declare(strict_types=1);

namespace BeeGame\Model;

class WorkerBee extends Bee
{
    public function __construct()
    {
        parent::__construct(HP::fromValue(75));
    }

    public function getType(): string
    {
        return 'Worker';
    }

    protected function getDamagePerHit(): HP
    {
        return HP::fromValue(10);
    }
}
