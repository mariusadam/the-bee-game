<?php

declare(strict_types=1);

namespace BeeGame\Http;

interface ControllerInterface
{
    public function __invoke(Request $request): Response;
}
