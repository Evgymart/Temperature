<?php

namespace Alignant\Temperature\controller;

use Alignant\Temperature\DTO\FailedResponse;
use Alignant\Temperature\models\MockSensorReading;
use Symfony\Component\HttpFoundation\Response;

class SensorController extends BaseController
{
    public function read(string $ip): Response
    {
        $response = $this->getResponse();
        $model = new MockSensorReading();
        $model->setIP($ip);
        $sensorData = $model->read();
        if (is_null($sensorData)) {
            $responseData = new FailedResponse('read');
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($responseData->toJSON());
            return $response;
        }

        $response->setContent($sensorData->toCSV());
        return $response;
    }
}
