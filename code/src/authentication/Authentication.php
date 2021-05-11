<?php


namespace feedshop\authentication;

use Exception;
use feedshop\http\RequestInterface;

class Authentication
{
    public const HEADERKEY = 'api-token';

    private AuthenticationConfig $authenticationConfig;

    public function __construct(AuthenticationConfig $authenticationConfig)
    {
        $this->authenticationConfig = $authenticationConfig;
    }

    public function validateRequestToken(RequestInterface $request): bool
    {
        try {
        $requestHeader = $request->getHeader(self::HEADERKEY);
        return $this->validatedTokenUserValue($requestHeader->getValue());
        } catch(Exception $exception)
        {
            return false;
        }
    }

    private function validatedTokenUserValue(string $tokenValue): string
    {
        $tokenList = $this->authenticationConfig->getTokenList();
        $requestedTokenValues = explode(' ', $tokenValue);
        foreach($tokenList as $user => $token){
            if (strtolower($user) === strtolower($requestedTokenValues[0]) && strtolower($token) === strtolower($requestedTokenValues[1]))
            {
                return true;
            }
        }
        return false;
    }
}