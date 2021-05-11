<?php


namespace feedshop\actions\employee;


use feedshop\Action;
use feedshop\http\HttpFactory;
use feedshop\http\RequestInterface;
use feedshop\http\ResponseInterface;
use feedshop\persistence\employee\EmployeeReader;

class EmployeeGetByIdAction implements Action
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
        $employee = $this->employeeReader->getEmployeeById($arguments["id"]);

        $response->setBody(json_encode($employee));
        $response->setHeader($this->factory->createHeader('content-type', 'application/json'));
        return $response;
    }
}