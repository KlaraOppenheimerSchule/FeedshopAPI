<?php


namespace feedshop\http;


use feedshop\http\wrapper\FileWrapper;
use feedshop\http\wrapper\ServerWrapper;
use feedshop\http\wrapper\VariablesWrapper;

class HttpFactory
{
    public function createHeader(string $key, string $value): Header
    {
        return new Header($key, $value);
    }

    public function createResponse(): ResponseInterface
    {
        $response = new Response();

        $response->setHeader($this->createHeader("Access-Control-Allow-Origin", "*"));
        $response->setHeader($this->createHeader("Access-Control-Allow-Methods", "GET, PUT, POST, DELETE, OPTIONS"));
        $response->setHeader($this->createHeader("Access-Control-Allow-Headers", "API-token"));

        return $response;
    }

    public function createUri(string $string): Uri
    {
        return new Uri($string);
    }

    public function createRequest(): RequestInterface
    {
        return new Request(
            new ServerWrapper(),
            new VariablesWrapper(),
            new FileWrapper(),
            new HttpFactory()
        );
    }
}