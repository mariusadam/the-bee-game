<?php

declare(strict_types=1);

namespace BeeGame\Model;

class DroneBee extends Bee
{
    public function __construct()
    {
        parent::__construct(HP::fromValue(50));
    }

    public function getType(): string
    {
        return 'Drone';
    }

    protected function getDamagePerHit(): HP
    {
        return HP::fromValue(12);
    }
}
