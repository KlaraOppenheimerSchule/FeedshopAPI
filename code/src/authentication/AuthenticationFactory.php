<?php


namespace feedshop\database;


use feedshop\authentication\AuthenticationConfig;

class AuthenticationFactory
{
    public function createAuthenticationConfig(array $apiTokenList): AuthenticationConfig
    {
        return new AuthenticationConfig($apiTokenList);
    }
}