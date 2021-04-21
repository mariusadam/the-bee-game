<?php

declare(strict_types=1);

use BeeGame\DI\Container;
use BeeGame\Http\Kernel;
use BeeGame\Http\Request;

require_once __DIR__.'/../vendor/autoload.php';

/** @var Container $container */
$container = require_once __DIR__.'/../config/container.php';

$request = new Request(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['PATH_INFO'] ?? '/',
    $_SERVER['SERVER_PROTOCOL'],
    $_POST
);

/** @var Kernel $kernel */
$kernel = $container->get(Kernel::class);
$response = $kernel->handle($request);
$response->send();
