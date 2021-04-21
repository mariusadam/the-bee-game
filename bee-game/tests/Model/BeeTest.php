<?php

declare(strict_types=1);

namespace Tests\Model;

use BeeGame\Model\Bee;
use BeeGame\Model\HP;
use PHPUnit\Framework\TestCase;

class BeeTest extends TestCase
{
    public function testAcceptHit(): void
    {
        $damagePerHit = HP::fromValue(3);
        $bee = new MockBee(HP::fromValue(5), $damagePerHit);

        self::assertEquals($damagePerHit, $bee->acceptHit());
        self::assertEquals(HP::fromValue(2), $bee->getHp());
        self::assertFalse($bee->isDead());
        self::assertFalse($bee->isWhenDeadCalled());
    }

    public function testAcceptHitWhenTheBeeDies(): void
    {
        $bee = new MockBee(
            HP::fromValue(11),
            HP::fromValue(20)
        );

        $expectedDamage = HP::fromValue(11);
        self::assertEquals($expectedDamage, $bee->acceptHit());
        self::assertTrue($bee->isDead());
        self::assertTrue($bee->isWhenDeadCalled());
    }
}

class MockBee extends Bee
{
    private HP $damagePerHit;
    private bool $whenDeadCalled;

    public function __construct(HP $initialHp, HP $damagePerHit)
    {
        parent::__construct($initialHp);
        $this->damagePerHit = $damagePerHit;
        $this->whenDeadCalled = false;
    }

    public function getType(): string
    {
        return 'Mock';
    }

    public function isWhenDeadCalled(): bool
    {
        return $this->whenDeadCalled;
    }

    protected function whenDead(): void
    {
        $this->whenDeadCalled = true;
    }

    protected function getDamagePerHit(): HP
    {
        return $this->damagePerHit;
    }
}
