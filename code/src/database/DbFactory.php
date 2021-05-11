<?php


namespace feedshop\database;

class DbFactory
{
    public function createConfig(
        string $username,
        string $password,
        string $dbname,
        string $host,
        int $port
    ): DbConfig
    {
        return new DbConfig(
            $username,
            $password,
            $dbname,
            $host,
            $port
        );
    }
}