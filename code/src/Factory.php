<?php
namespace feedshop;

use PDO;

use feedshop\actions\employee\EmployeeGetAction;
use feedshop\actions\employee\EmployeeGetByIdAction;
use feedshop\actions\employee\EmployeePutAction;
use feedshop\actions\employee\EmployeeDeleteAction;
use feedshop\actions\employee\EmployeePostAction;
use feedshop\persistence\employee\EmployeeReader;
use feedshop\persistence\employee\EmployeeWriter;

use feedshop\authentication\Authentication;
use feedshop\database\AuthenticationFactory;
use feedshop\database\Configuration;
use feedshop\database\DbConfig;
use feedshop\database\DbConnector;
use feedshop\database\DbFactory;
use feedshop\http\HttpFactory;
use feedshop\router\RouterFactory;

class Factory
{
    private Configuration $configuration;

    private RouterFactory $routerFactory;

    private HttpFactory $httpFactory;

    private DbConnector $dbConnector;

    private Authentication $authentication;

    public function __construct()
    {
        $this->configuration = $this->createConfiguration();
        $this->routerFactory = $this->createRouterFactory();
        $this->httpFactory = $this->createHttpFactory();
        $this->dbConnector = $this->createDbConnection(
            $this->configuration->getDbConfig()
        );
        $this->authentication = $this->createAuthentication();
    }

    private function getConfigPath(): string
    {
        $configPath = __DIR__ . '/config/%s/application.ini';
        $env = getenv('APPLICATION_ENVIRONMENT');
        if ($env === 'production') {
            return sprintf($configPath, 'production');
        }
        return sprintf($configPath, 'development');
    }

    private function createDbFactory(): DbFactory
    {
        return new DbFactory();
    }

    public function createConfiguration(): Configuration
    {
        return new Configuration(
            $this->getConfigPath(),
            $this->createDbFactory(),
            $this->createAuthenticationFactory()
        );
    }

    private function createAuthenticationFactory(): AuthenticationFactory
    {
        return new AuthenticationFactory();
    }

    public function createDbConnection(DbConfig $dbConfig): DbConnector
    {
        return new DbConnector(
            new Pdo(
                $dbConfig->getDsn(),
                $dbConfig->getUsername(),
                $dbConfig->getPassword()
            )
        );
    }

    public function createAuthentication(): Authentication
    {
        return new Authentication(
            $this->configuration->getAuthenticationConfig()
        );
    }

    public function createApplication(): Application
    {
        $application = new Application(
            $this->routerFactory->createRouter(),
            $this->httpFactory,
            $this->authentication
        );

        //Adding Routes
        $application->addPostRoute("/employee", $this->createEmployeePostAction());
        $application->addGetRoute("/employee/{id}", $this->createEmployeeGetByIdAction());
        $application->addDeleteRoute("/employee/{id}", $this->createEmployeeDeleteAction());
        $application->addGetRoute("/employee", $this->createEmployeeGetAction());
        $application->addPutRoute("/employee", $this->createEmployeePutAction());

        return $application;
    }

    //Factory-Helpermethods
    private function createRouterFactory(): RouterFactory
    {
        return new RouterFactory();
    }

    private function createHttpFactory(): HttpFactory
    {
        return new HttpFactory();
    }


    //Actionmethods, which could be called
    private function createEmployeePostAction(): EmployeePostAction
    {
        return new EmployeePostAction(
            new EmployeeWriter(
                $this->dbConnector,
                new EmployeeReader($this->dbConnector)
            )
        );
    }

    private function createEmployeePutAction(): EmployeePutAction
    {
        return new EmployeePutAction(
            new EmployeeWriter(
                $this->dbConnector,
                new EmployeeReader($this->dbConnector)
            )
        );
    }

    private function createEmployeeDeleteAction(): EmployeeDeleteAction
    {
        return new EmployeeDeleteAction(
            new EmployeeWriter(
                $this->dbConnector,
                new EmployeeReader($this->dbConnector)
            )
        );
    }

    private function createEmployeeGetAction(): EmployeeGetAction
    {
        return new EmployeeGetAction(
            new EmployeeReader(
                $this->dbConnector,
            ),
            new HttpFactory()
        );
    }

    private function createEmployeeGetByIdAction(): EmployeeGetByIdAction
    {
        return new EmployeeGetByIdAction(
            new EmployeeReader(
                $this->dbConnector,
            ),
            new HttpFactory()
        );
    }
    
}