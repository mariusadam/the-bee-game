<?php

declare(strict_types=1);

namespace BeeGame\Model;

use InvalidArgumentException;

/**
 * Imposes a general behaviour of the a bee
 * by using template method pattern
 *
 * New bee type can be added by creating an implementation of this class
 * and instantiating it in the swarm
 */
abstract class Bee
{
    private HP $hp;

    public function __construct(HP $initialHp)
    {
        $this->hp = $initialHp;
    }

    /**
     * @return HP Inflicted damage
     */
    public function acceptHit(): HP
    {
        $initialHp = $this->hp;
        try {
            $this->hp = $initialHp->subtract($this->getDamagePerHit());
        } catch (InvalidArgumentException $ex) {
            // the damage per hit is greater than the actual hp, so the bee dies
            $this->die();
        }

        return $initialHp->subtract($this->hp);
    }

    abstract protected function getDamagePerHit(): HP;

    public function die(): void
    {
        $this->hp = HP::zero();
        $this->whenDead();
    }

    /**
     * Hook method that can be used by different implementations to
     * perform some action when the bee dies
     */
    protected function whenDead(): void
    {

    }

    public function getHp(): HP
    {
        return $this->hp;
    }

    public function isDead(): bool
    {
        return $this->hp->equals(HP::zero());
    }

    abstract public function getType(): string;
}
