<?php


namespace feedshop\domain;


use DateTime;
use JsonSerializable;

class Employee implements JsonSerializable
{
    private ?int $id;
    private string $firstname;
    private string $lastname;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;

    private function __construct(
        $id,
        $firstname,
        $lastname,
        $createdAt,
        $updatedAt
    ) {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    static public function fromPostRequest(string $firstname, string $lastname, ?int $id = null): Employee
    {
        return new Employee($id, $firstname, $lastname, null, null);
    }

    static public function fromDatabase(
        int $id,
        string $firstname,
        string $lastname,
        DateTime $createdAt,
        ?DateTime $updatedAt
    ): Employee {
        return new Employee($id, $firstname, $lastname, $createdAt, $updatedAt);
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        if ($this->updatedAt == null) {
            return [
                "id" => $this->id,
                "firstname" => $this->firstname,
                "lastname" => $this->lastname,
                "createdAt" => $this->createdAt->format(DATE_ISO8601),
                "updatedAt" => null
            ];
        }
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "createdAt" => $this->createdAt->format(DATE_ISO8601),
            "updatedAt" => $this->updatedAt->format(DATE_ISO8601)
        ];
    }
}