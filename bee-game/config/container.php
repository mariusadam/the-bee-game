<?php /** @noinspection PhpParamsInspection */

declare(strict_types=1);

use BeeGame\Controller\DefaultController;
use BeeGame\Controller\HitBeeController;
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
use BeeGame\Util\RandomPicker;

return new Container(
    [
        'templates_dir' => __DIR__.'/../templates',
    ],
    [
        Kernel::class                  => fn(Container $container): Kernel => new Kernel(
            $container->get(Router::class)
        ),
        Router::class                  => fn(Container $container): Router => new Router(
            [
                new Route('GET', '/', $container->get(HomepageController::class)),
                new Route('POST', '/new-game', $container->get(NewGameController::class)),
                new Route('GET', '/play', $container->get(PlayController::class)),
                new Route('POST', '/hit-bee', $container->get(HitBeeController::class)),
            ],
            $container->get(DefaultController::class)
        ),
        DefaultController::class       => fn(Container $container): DefaultController => new DefaultController(
            $container->get(TemplateEngineInterface::class)
        ),
        TemplateEngineInterface::class => fn(Container $container): PHtmlTemplateEngine => new PHtmlTemplateEngine(
            $container->getParameter('templates_dir')
        ),
        HomepageController::class      => fn(Container $container): HomepageController => new HomepageController(
            $container->get(Session::class),
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
        HitBeeController::class        => fn(Container $container): HitBeeController => new HitBeeController(
            $container->get(Session::class),
            $container->get(RandomPicker::class),
            $container->get(GameFactory::class)
        ),
        RandomPicker::class            => fn(Container $container): RandomPicker => new RandomPicker(),
    ]
);
