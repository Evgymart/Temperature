<?php
declare(strict_types=1);

namespace Alignant\Temperature;

use Alignant\Temperature\DTO\ErrorResponse;
use Alignant\Temperature\router\Router;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class App
{
    private ?Connection $conn;
    private ?Router $router;

    public function __construct(private readonly string $rootPath)
    {
        $this->initConnection();
    }


    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function run(): void
    {
        $request = Request::createFromGlobals();

        try {
            $this->router->init($this->getRootPath());
            $response = $this->router->route($request);
        } catch (HttpException $e) {
            $response = new Response();
            $response->setStatusCode($e->getStatusCode());
            $responseData = new ErrorResponse($e->getMessage(), $e->getStatusCode());
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($responseData->toJSON());
            $response->send();
        }

        $response->send();
    }

    public function getConnection(): Connection
    {
        return $this->conn;
    }

    private function initConnection(): void
    {
        $dsn = new DsnParser(['postgres' => 'pdo_pgsql']);
        $params = require_once $this->rootPath . '/migrations-db.php';
        $this->conn = DriverManager::getConnection($params);
    }
}
