<?php

declare(strict_types=1);

namespace BeeGame\DI;

use InvalidArgumentException;

/**
 * Simple dependency container implementation, it
 * does not handle circular references or does any advanced stuff
 */
class Container
{
    private array $parameters;
    private array $serviceFactories;
    private array $services = [];

    public function __construct(array $parameters, array $serviceFactories)
    {
        $this->parameters = $parameters;
        $this->serviceFactories = $serviceFactories;
    }

    public function get(string $serviceId): object
    {
        if (false === array_key_exists($serviceId, $this->services)) {
            $this->services[$serviceId] = $this->instantiate($serviceId);
        }

        return $this->services[$serviceId];
    }

    private function instantiate(string $serviceId): object
    {
        $factory = $this->serviceFactories[$serviceId] ?? null;
        if (null === $factory) {
            throw new InvalidArgumentException(sprintf('Service "%s" is not defined.', $serviceId));
        }

        return $factory($this);
    }

    /**
     * @return mixed
     */
    public function getParameter(string $parameterName)
    {
        if (array_key_exists($parameterName, $this->parameters)) {
            return $this->parameters[$parameterName];
        }

        throw new InvalidArgumentException(sprintf('Parameter "%s" is not defined.', $parameterName));
    }
}
