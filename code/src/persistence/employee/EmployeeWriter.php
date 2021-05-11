<?php


namespace feedshop\persistence\employee;


use feedshop\database\DbConnector;
use feedshop\domain\Employee;

class EmployeeWriter
{
    private DbConnector $dbConnector;
    private EmployeeReader $employeeReader;

    public function __construct(DbConnector $dbConnector, EmployeeReader $employeeReader)
    {
        $this->dbConnector = $dbConnector;
        $this->employeeReader = $employeeReader;
    }

    public function writeNewEmployee(employee $employee): Employee
    {
        $pdo = $this->dbConnector->getConnection();
        $statement = $pdo->prepare("INSERT INTO employee (firstname, lastname) VALUES (?,?)");

        $statement->execute([$employee->getFirstname(), $employee->getLastname()]);
        $employee = $this->employeeReader->getLastEmployee();
        return $employee;
    }
    

    public function delete($id)
    {
        $pdo = $this->dbConnector->getConnection();
        $statement = $pdo->prepare("DELETE FROM employee WHERE employeeID = ?");

        $statement->execute([$id]);
    }

    public function updateEmployee(Employee $employee): Employee
    {
        $pdo = $this->dbConnector->getConnection();
        //TODO: ADD Firstname to be changed
        $statement = $pdo->prepare("UPDATE employee SET lastname = ?, firstname = ?, lastUpdateDT = CURRENT_TIMESTAMP WHERE employeeID = ?");
        $statement->execute([$employee->getLastname(), $employee->getFirstname(), $employee->getId()]);
        $employee = $this->employeeReader->getEmployeeById($employee->getId());
        return $employee;
    }
}