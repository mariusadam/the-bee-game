<?php /** @noinspection PhpParamsInspection */

declare(strict_types=1);

use BeeGame\Controller\DefaultController;
use BeeGame\Controller\HomepageController;
use BeeGame\Controller\NewGameController;
use BeeGame\Controller\PlayController;
use BeeGame\DI\Container;
use BeeGame\Factory\GameFactory;
use BeeGame\Http\Kernel;
use BeeGame\Http\Route;
use BeeGame\Http\Router;
use BeeGame\Http\Session;
use BeeGame\Templating\PHtmlTemplateEngine;
use BeeGame\Templating\TemplateEngineInterface;

return new Container(
    [],
    [
        Kernel::class                  => fn(Container $container): Kernel => new Kernel(
            $container->get(Router::class)
        ),
        Router::class                  => fn(Container $container): Router => new Router(
            [
                new Route('GET', '/', $container->get(HomepageController::class)),
                new Route('POST', '/new-game', $container->get(NewGameController::class)),
                new Route('GET', '/play', $container->get(PlayController::class)),
            ],
            $container->get(DefaultController::class)
        ),
        DefaultController::class       => fn(Container $container): DefaultController => new DefaultController(
            $container->get(TemplateEngineInterface::class)
        ),
        TemplateEngineInterface::class => fn(Container $container): PHtmlTemplateEngine => new PHtmlTemplateEngine(
            __DIR__.'/../templates'
        ),
        HomepageController::class      => fn(Container $container): HomepageController => new HomepageController(
            $container->get(TemplateEngineInterface::class)
        ),
        NewGameController::class       => fn(Container $container): NewGameController => new NewGameController(
            $container->get(GameFactory::class),
            $container->get(Session::class)
        ),
        GameFactory::class             => fn(Container $container): GameFactory => new GameFactory(),
        Session::class                 => fn(Container $container): Session => new Session(),
        PlayController::class          => fn(Container $container): PlayController => new PlayController(
            $container->get(Session::class),
            $container->get(TemplateEngineInterface::class)
        ),
    ]
);
