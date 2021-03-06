<?php

declare(strict_types=1);

namespace BeeGame\Http;

/**
 * Not covered by tests
 */
class Session
{
    public function set(string $key, $value): void
    {
        $this->ensureIsStarted();

        $_SESSION[$key] = $value;
    }

    private function ensureIsStarted(): void
    {
        if (PHP_SESSION_NONE === session_status()) {
            session_start();
        }
    }

    public function get(string $key)
    {
        $this->ensureIsStarted();

        return $_SESSION[$key] ?? null;
    }

    public function getAndRemove(string $key)
    {
        $value = $this->get($key);

        unset($_SESSION[$key]);

        return $value;
    }
}
