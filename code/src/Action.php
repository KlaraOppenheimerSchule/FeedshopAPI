<?php


namespace feedshop;

use feedshop\http\RequestInterface;
use feedshop\http\ResponseInterface;

interface Action
{
    public  function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        array $arguments
    ): ResponseInterface;
}