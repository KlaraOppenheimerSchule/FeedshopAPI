<?php


namespace feedshop\actions\employee;


use feedshop\Action;
use feedshop\http\RequestInterface;
use feedshop\http\ResponseInterface;
use feedshop\persistence\employee\EmployeeWriter;

class EmployeeDeleteAction implements Action
{
    private EmployeeWriter $employeeWriter;

    public function __construct(EmployeeWriter $employee)
    {
        $this->employeeWriter = $employee;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $arguments): ResponseInterface
    {
        $this->employeeWriter->delete($arguments["id"]);
        return $response;
    }

}