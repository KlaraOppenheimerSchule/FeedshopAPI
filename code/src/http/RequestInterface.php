<?php


namespace feedshop\http;


Interface RequestInterface
{
    public function getHeader(string $key): Header;

    public function getBody(): string;

    public function getQueryParam(string $key): string;

    public function getHttpMethod(): string;

    public function getRequestUri(): Uri;
}