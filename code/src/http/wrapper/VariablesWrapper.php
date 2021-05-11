<?php


namespace feedshop\http\wrapper;


use InvalidArgumentException;

class VariablesWrapper
{
    public function getPostParam($key): string
    {
        if (array_key_exists($key, $_POST)) return $_POST[$key];
        throw new InvalidArgumentException("QueryParam $key does not exists");
    }

    public function getGetParam($key): string
    {
        if (array_key_exists($key, $_GET)) return $_GET[$key];
        throw new InvalidArgumentException("QueryParam $key does not exists");
    }
}