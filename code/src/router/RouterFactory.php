<?php


namespace feedshop\router;


use feedshop\Action;

class RouterFactory
{

    public function createRoute(string $uri, Action $action, string $method): Route
    {
        return new Route($uri, $action, $method);
    }

    public function createRouter(): \feedshop\Router
    {
        return new Router($this);
    }
}