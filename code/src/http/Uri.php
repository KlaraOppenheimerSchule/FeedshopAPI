<?php

namespace feedshop\http;

use InvalidArgumentException;

class Uri
{
    /**
     * @var String
     */
    private string $uri;

    public function __construct(String $string)
    {
        $this->validate($string);
        $this->uri = $string;
    }

    private function validate(String $string): void
    {
        if (empty($string)) {
            throw new InvalidArgumentException('URI is empty');
        }
        if (!preg_match('/^[\/]{0,1}([a-z0-9]+[\/]{0,1})+$/mi', $string)) {
            throw new InvalidArgumentException('URI is invalid: ' . $string);
        }
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}