<?php

namespace feedshop\router;

use feedshop\Action;

class Route
{
    private string $uri;
    private Action $action;
    private string $method;

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction(): Action
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function __construct(string $uri, Action $action, string $method)
    {
        $this->uri = $uri;
        $this->action = $action;
        $this->method = $method;
    }
}