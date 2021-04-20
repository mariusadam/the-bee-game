<?php

declare(strict_types=1);

namespace BeeGame\Http;

class Kernel
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle(Request $request): Response
    {
        $controller = $this->router->match($request);

        $response = $controller($request);
        $response->prepare($request);

        return $response;
    }
}
