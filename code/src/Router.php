<?php


namespace feedshop;


use feedshop\http\Uri;

interface Router
{
    public function getAction(Uri $uri, string $method): Action;

    public function addRoute(string $uri, Action $action, string $method);

    public function getRequestUrlArguments(Uri $uri): array;
}