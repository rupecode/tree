<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\Application;
use Aura\Sql\ExtendedPdo;
use League\Plates\Engine;

$container = new DI\Container([
    Engine::class => new League\Plates\Engine(__DIR__ . '/../app/Templates'),
    ExtendedPdo::class => new ExtendedPdo(
        'mysql:host=mysql;dbname=homestead',
        'homestead',
        'secret'
    ),
]);

$router = $container->get(Application::class);
$router->run();
