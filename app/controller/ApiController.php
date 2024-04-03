<?php
declare(strict_types=1);

namespace Alignant\Temperature\controller;

use Alignant\Temperature\DTO\FailedResponse;
use Alignant\Temperature\DTO\OkResponse;
use Alignant\Temperature\models\TemperatureReading;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends BaseController
{
    public function push(): Response
    {
        $request = $this->getRequest();
        $model = new TemperatureReading();
        $model->setData($request->getPayload()->all());
        $response = $this->getResponse();
        if (!$model->save()) {
            $responseData = new FailedResponse('push');

        } else {
            $responseData = new OkResponse('push');
        }

        $response->setContent($responseData->toJSON());
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}