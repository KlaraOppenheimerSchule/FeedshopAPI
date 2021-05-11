<?php


namespace feedshop\database;

use Exception;
use feedshop\authentication\AuthenticationConfig;
use feedshop\exception\InvalidConfigurationException;

class Configuration
{
    private DbFactory $dbFactory;

    private DbConfig $dbConfig;

    private AuthenticationFactory $authenticationFactory;

    private AuthenticationConfig $authenticationConfig;

    public function __construct(
        string $configPath,
        DbFactory $dbFactory,
        AuthenticationFactory $authenticationFactory
    )
    {
        $this->dbFactory = $dbFactory;
        $this->authenticationFactory = $authenticationFactory;

        $this->validate($configPath);
        $this->setConfiguration($configPath);
    }

    private function validate(string $configPath): void
    {
        try{
            parse_ini_file($configPath);
        }catch(Exception $exception)
        {
            throw new InvalidConfigurationException('Given ConfigPath is missing or cant be parsed!');
        }
    }

    private function setConfiguration(string $configPath): void
    {
        $configContent = parse_ini_file($configPath, true);
        $this->dbConfig = $this->dbFactory->createConfig(
            $configContent['mySqlUsername'],
            $configContent['mySqlPassword'],
            $configContent['mySqlDbName'],
            $configContent['mySqlHost'],
            $configContent['mySqlPort']
        );

        $this->authenticationConfig = $this->authenticationFactory->createAuthenticationConfig(
            $configContent['apiTokenList']
        );
    }

    public function getDbConfig(): DbConfig
    {
        return $this->dbConfig;
    }

    public function getAuthenticationConfig(): AuthenticationConfig
    {
        return $this->authenticationConfig;
    }
}