<?php

namespace feedshop;

use feedshop\authentication\Authentication;
use feedshop\http\HttpFactory;
use feedshop\router\exception\MethodNotAllowedException;
use feedshop\router\exception\RouteNotFoundException;

class Application
{
    private Router $router;

    private HttpFactory $httpFactory;

    private Authentication $authentication;

    public function __construct(
        Router $router,
        HttpFactory $httpFactory,
        Authentication $authentication
    ) {
        $this->router = $router;
        $this->httpFactory = $httpFactory;
        $this->authentication = $authentication;
    }

    public function run()
    {
        try {
            $request = $this->httpFactory->createRequest();
            $response = $this->httpFactory->createResponse();

            $uri = $request->getRequestUri();

            if ($this->authentication->validateRequestToken($request)) {
                $action = $this->router->getAction($uri, $request->getHttpMethod());

                $response = $action($request, $response, $this->router->getRequestUrlArguments($uri));
                $response->send();
            } else {
                // browser corse request edge case
                if (strtolower($request->getHttpMethod()) == "options"){
                    $response->setResponseCode(200);
                } else {
                    $response->setResponseCode(403);
                }

                $response->send();
            }
        } catch(RouteNotFoundException $exception)
        {
            $response->setResponseCode(404);
            $response->setBody($this->createCapsuledBodyMessage($exception->getMessage()));
            $response->send();
        } catch(MethodNotAllowedException $exception)
        {
            $response->setResponseCode(405);
            $response->setBody($this->createCapsuledBodyMessage($exception->getMessage()));
            $response->send();
        }
    }

    private function createCapsuledBodyMessage(string $message)
    {
        return sprintf('{"message":"%s"}', $message);
    }

    public function addGetRoute(string $uri, Action $action)
    {
        $this->addRoute($uri, "GET", $action);
    }

    public function addPostRoute(string $uri, Action $action)
    {
        $this->addRoute($uri, "POST", $action);
    }

    public function addPutRoute(string $uri, Action $action)
    {
        $this->addRoute($uri, "PUT", $action);
    }

    public function addDeleteRoute(string $uri, Action $action)
    {
        $this->addRoute($uri, "DELETE", $action);
    }

    private function addRoute(string $uri, string $method, Action $action)
    {
        $this->router->addRoute($uri, $action, $method);
    }
}