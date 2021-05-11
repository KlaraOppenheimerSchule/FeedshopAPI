<?php


namespace feedshop\persistence\employee;


use DateTime;
use feedshop\database\DbConnector;
use feedshop\domain\Employee;

class EmployeeReader
{
    private DbConnector $dbConnector;

    public function __construct(DbConnector $dbConnector)
    {
        $this->dbConnector = $dbConnector;
    }

    
    public function getLastEmployee() : Employee
    {
        $pdo = $this->dbConnector->getConnection();
        $statement = $pdo->prepare("SELECT * FROM employee ORDER BY employeeID DESC LIMIT 1");
        $statement->execute();

        $employeeDbArray = $statement->fetchAll()[0];

        if ($employeeDbArray["lastUpdateDT"] == null) {
            return Employee::fromDatabase(
                $employeeDbArray["employeeID"],
                $employeeDbArray["firstname"],
                $employeeDbArray["lastname"],
                new DateTime($employeeDbArray["createDT"]),
                null
            );
        }

        return Employee::fromDatabase(
            $employeeDbArray["employeeID"],
            $employeeDbArray["firstname"],
            $employeeDbArray["lastname"],
            new DateTime($employeeDbArray["createDT"]),
            new DateTime($employeeDbArray["lastUpdateDT"]),
        );

    }

    /** @return Employee[] */
    public function getAllEmployees(): array
    {
        $employees = [];
        $pdo = $this->dbConnector->getConnection();
        $statement = $pdo->prepare("SELECT * FROM employee");
        $statement->execute();

        $values = $statement->fetchAll();
        foreach ($values as $value) {
            if ($value["lastUpdateDT"] == null) {
                $employees[] = Employee::fromDatabase(
                    $value["employeeID"],
                    $value["firstname"],
                    $value["lastname"],
                    new DateTime($value["createDT"]),
                    null
                );
            } else {
                $employees[] = Employee::fromDatabase(
                    $value["employeeID"],
                    $value["firstname"],
                    $value["lastname"],
                    new DateTime($value["createDT"]),
                    new DateTime($value["lastUpdateDT"])
                );
            }
        }

        return $employees;
    }

    

    public function getEmployeeById(string $id)
    {
        $pdo = $this->dbConnector->getConnection();
        $statement = $pdo->prepare("SELECT * FROM employee WHERE employeeID = ?");
        $statement->execute([$id]);
        $value = $statement->fetchAll()[0];

        if ($value["lastUpdateDT"] == null) {
            return Employee::fromDatabase(
                $value["employeeID"],
                $value["firstname"],
                $value["lastname"],
                new DateTime($value["createDT"]),
                null
            );
        }

        return Employee::fromDatabase(
            $value["employeeID"],
            $value["firstname"],
            $value["lastname"],
            new DateTime($value["createDT"]),
            new DateTime($value["lastUpdateDT"]),
        );
    }
}