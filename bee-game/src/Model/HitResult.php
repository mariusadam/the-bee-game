<?php

declare(strict_types=1);

namespace BeeGame\Model;

/**
 * Represents the result of hitting a bee
 */
class HitResult
{
    private Bee $bee;
    private HP $inflictedDamage;

    public function __construct(Bee $bee, HP $inflictedDamage)
    {
        $this->bee = $bee;
        $this->inflictedDamage = $inflictedDamage;
    }

    public function getBee(): Bee
    {
        return $this->bee;
    }

    public function getInflictedDamage(): HP
    {
        return $this->inflictedDamage;
    }
}
