<?php

declare(strict_types=1);

namespace BeeGame\Model;

use BeeGame\Exception\GameOverException;
use BeeGame\Util\RandomPicker;

class Game
{
    private string $playerName;
    private BeeSwarm $beeSwarm;
    private ?HitResult $lastHitResult;

    public function __construct(string $playerName, BeeSwarm $beeSwarm)
    {
        $this->playerName = $playerName;
        $this->beeSwarm = $beeSwarm;
        $this->lastHitResult = null;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    /**
     * @throws GameOverException
     */
    public function hitBee(RandomPicker $picker): void
    {
        try {
            /** @var Bee $chosenBee */
            $chosenBee = $picker->pick($this->beeSwarm->getAliveBeesGroupedByType());
        } catch (\InvalidArgumentException $ex) {
            // could not choose an alive bee -> game over
            throw new GameOverException();
        }

        $inflictedDamage = $chosenBee->acceptHit();

        $this->lastHitResult = new HitResult($chosenBee, $inflictedDamage);

        if (false === $this->beeSwarm->containsAliveBees()) {
            throw new GameOverException();
        }
    }

    public function getLastHitResult(): ?HitResult
    {
        return $this->lastHitResult;
    }

    public function getSwarm(): BeeSwarm
    {
        return $this->beeSwarm;
    }

    public function wasHitLastTime(Bee $bee): bool
    {
        return null !== $this->lastHitResult && $bee === $this->lastHitResult->getBee();
    }
}
