<?php


namespace feedshop\http;

class Header
{
    private string $key;
    private string $value;

    public function __construct(string $key, string $value)
    {
        $this->key = strtolower($key);
        $this->value = strtolower($value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}