<?php


namespace feedshop\database;

use PDO;

class DbConnector
{
    private PDO $pdoConnection;

    public function __construct(PDO $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection;
    }

    public function getConnection(): PDO
    {
        return $this->pdoConnection;
    }
}