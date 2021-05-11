<?php


namespace feedshop\http\wrapper;


class ServerWrapper
{
    public function getRequestMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function getRequestHeader(): array
    {
        return getallheaders();
    }

    public function getRequestUri(): string
    {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }
}