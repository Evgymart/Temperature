<?php
declare(strict_types=1);

namespace Alignant\Temperature;

use Alignant\Temperature\DTO\ErrorResponse;
use Alignant\Temperature\router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class App
{
    private ?Router $router;

    public function __construct(private string $rootPath)
    {
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

        die($response->getContent());
    }

    private function routing()
    {

    }

}
