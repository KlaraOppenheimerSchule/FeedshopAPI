<?php


namespace feedshop\actions\employee;


use feedshop\Action;
use feedshop\domain\Employee;
use feedshop\http\RequestInterface;
use feedshop\http\ResponseInterface;
use feedshop\persistence\employee\EmployeeWriter;

class EmployeePostAction implements Action
{
    private EmployeeWriter $employeeWriter;

    public function __construct(EmployeeWriter $employee)
    {
        $this->employeeWriter = $employee;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $arguments): ResponseInterface
    {
        $contentType = $request->getHeader("content-type");

        if (strtolower($contentType->getValue()) !== "application/json") {
            $response->setResponseCode(415);
            $response->setBody('{message: only json support}');
            return $response;
        }

        $body = json_decode($request->getBody(), true);

        if (!array_key_exists("lastname", $body)) {
            $response->setResponseCode(400);
            $response->setBody('{message: invalid json}');
            return $response;
        }

        $employee = Employee::fromPostRequest($body["firstname"], $body["lastname"]);

        $employee = $this->employeeWriter->writeNewEmployee($employee);

        $response->setBody(json_encode($employee));
        return $response;
    }
}