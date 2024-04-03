<?php
declare(strict_types=1);

namespace Alignant\Temperature\controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    private Response $response;
    public function __construct(private Request $request)
    {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function getResponse(): Response
    {
        return $this->response;
    }
}
