<?php


namespace feedshop\database;

use feedshop\exception\InvalidConfigurationException;

class DbConfig
{
    private string $username;

    private string $password;

    private string $dsn;

    public function __construct(
        string $username,
        string $password,
        string $dbname,
        string $host,
        int $port
    ) {
        $this->validate($username, $password, $dbname, $host, $port);

        $this->username = $username;
        $this->password = $password;
        $this->dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', $host, $port, $dbname);
    }

    private function validate(string $username, string $password, string $dbname, string $host, int $port): void
    {
        if (empty($username) || empty($password) || empty($dbname) || empty($host) || empty($port))
        {
            throw new InvalidConfigurationException('DbConfig values empty!');
        }
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDsn(): string
    {
        return $this->dsn;
    }
}