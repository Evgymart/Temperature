<?php

namespace Alignant\Temperature\controller;

use Alignant\Temperature\DTO\OkResponse;
use Symfony\Component\HttpFoundation\Response;

class SensorController extends BaseController
{
    public function read(string $ip): Response
    {
        $response = $this->getResponse();
        $response->setContent($ip);
        return $response;
    }
}