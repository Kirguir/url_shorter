<?php

use FastRoute\RouteCollector;

$container = require __DIR__ . '/../app/bootstrap.php';

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controller\LinkController', 'index']);
    $r->addRoute('POST', '/add', ['App\Controller\LinkController', 'addLink']);
    $r->addRoute('GET', '/{short_url}', ['App\Controller\LinkController', 'viewLink']);
    $r->addRoute('GET', '/stat/{short_url}', ['App\Controller\LinkController', 'statistic']);
});

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;

    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];

        $container->call($controller, $parameters);
        break;
}