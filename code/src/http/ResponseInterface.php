<?php


namespace feedshop\http;


interface ResponseInterface
{
    public function setHeader(Header $header);
    public function setBody(string $body);
    public function setResponseCode(int $code);
    public function send();
}