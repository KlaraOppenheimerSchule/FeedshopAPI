<?php


namespace feedshop\authentication;


use feedshop\exception\InvalidConfigurationException;

class AuthenticationConfig
{
    private array $tokenList;

    public function __construct(array $tokenList)
    {
        $this->validate($tokenList);
        $this->tokenList = $tokenList;
    }

    private function validate(array $tokenList): void
    {
        if (empty($tokenList))
        {
            throw new InvalidConfigurationException('AuthenticationConfig values empty!');
        }
    }

    public function getTokenList(): array
    {
        return $this->tokenList;
    }
}