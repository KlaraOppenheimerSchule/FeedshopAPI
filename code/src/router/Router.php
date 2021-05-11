<?php

namespace feedshop\router;

use feedshop\Action;
use feedshop\http\Uri;
use feedshop\router\exception\MethodNotAllowedException;
use feedshop\router\exception\RouteNotFoundException;

class Router implements \feedshop\Router
{

    /** @var Route[]  */
    private array $routes;

    private RouterFactory $factory;

    public function __construct(RouterFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Uri $uri
     * @param string $method
     * @return Action
     * @throws RouteNotFoundException
     * @throws MethodNotAllowedException
     */
    public function getAction(Uri $uri, string $method): Action
    {
        return $this->getActualRoute($uri, $method)->getAction();
    }

    public function addRoute(string $uri, Action $action, string $method)
    {
        $this->routes[] = $this->factory->createRoute($uri, $action, $method);
    }

    public function getRequestUrlArguments(Uri $uri): array
    {
        $arguments = [];
        $requestUriSegments = explode("/", $uri->getUri());
        $templateUriSegments = explode("/", $this->findValidUris($uri)[0]->getUri());
        for ($i = 1; $i < sizeof($templateUriSegments); $i++) {
            if ($this->checkUriWildcard($templateUriSegments[$i])) {
                $arguments[
                    substr(
                        $templateUriSegments[$i],
                        1,
                        strlen($templateUriSegments[$i])-2)
                ] = $requestUriSegments[$i];
            }
        }

        return $arguments;
    }

    private function getActualRoute(Uri $uri, string $method): Route
    {
        $candidates = $this->findValidUris($uri);
        if (count($candidates) < 1) {
            throw new RouteNotFoundException("URI not found");
        }

        foreach ($candidates as $route) {
            if (strtolower($method) === strtolower($route->getMethod())) return $route;
        }
        throw new MethodNotAllowedException("Method $method is not allowed");
    }

    /**
     * @param Uri $requestUri
     * @return Route[]
     */
    private function findValidUris(Uri $requestUri): array
    {
        /** @var Route[] $candidates */
        $candidates = [];

        $requestUriSegments = explode("/", $requestUri->getUri());

        foreach ($this->routes as $route) {
            $routeUriSegments = explode("/", $route->getUri());
            $correctUri = true;
            if (count($requestUriSegments) != count($routeUriSegments)) continue;
            for ($i = 1; $i < count($routeUriSegments); $i++) {

                if ($this->checkUriWildcard($routeUriSegments[$i])) continue;
                if (strtolower($routeUriSegments[$i]) === strtolower($requestUriSegments[$i])) continue;

                $correctUri = false;
            }

            if (!$correctUri) continue;
            $candidates[] = $route;
        }
        return $candidates;
    }

    private function checkUriWildcard(string $segment): bool
    {
        if ($segment[0] !== "{") return false;
        if ($segment[strlen($segment)-1] !== "}") return false;

        return true;
    }

}