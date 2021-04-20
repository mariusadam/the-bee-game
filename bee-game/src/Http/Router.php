<?php

declare(strict_types=1);

namespace BeeGame\Http;

class Router
{
    /**
     * @var array|Route[]
     */
    private array $availableRoutes;

    private ControllerInterface $defaultController;

    public function __construct(array $availableRoutes, ControllerInterface $defaultController)
    {
        $this->availableRoutes = $availableRoutes;
        $this->defaultController = $defaultController;
    }

    /**
     * Routes the given request to a controller
     */
    public function match(Request $request): ControllerInterface
    {
        foreach ($this->availableRoutes as $route) {
            if ($route->getMethod() === $request->getMethod() && $route->getPath() === $request->getPath()) {
                return $route->getController();
            }
        }

        return $this->defaultController;
    }
}
