<?php
declare(strict_types=1);

namespace Alignant\Temperature\controller;

use Alignant\Temperature\DTO\OkResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends BaseController
{

    public function push(): Response
    {
        $response = $this->getResponse();
        $responseData = new OkResponse('push');
        $response->setContent($responseData->toJSON());
        return $response;
    }
}