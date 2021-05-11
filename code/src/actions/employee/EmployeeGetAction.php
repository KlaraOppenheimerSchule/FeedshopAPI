<?php


namespace feedshop\actions\employee;


use feedshop\Action;
use feedshop\http\HttpFactory;
use feedshop\http\RequestInterface;
use feedshop\http\ResponseInterface;
use feedshop\persistence\employee\EmployeeReader;

class EmployeeGetAction implements Action
{
    private EmployeeReader $employeeReader;
    private HttpFactory $factory;

    public function __construct(EmployeeReader $employee, HttpFactory $factory)
    {
        $this->employeeReader = $employee;
        $this->factory = $factory;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $arguments): ResponseInterface
    {
        $employees = $this->employeeReader->getAllEmployees();

        $response->setBody(json_encode($employees));
        $response->setHeader($this->factory->createHeader('content-type', 'application/json'));
        return $response;
    }
}