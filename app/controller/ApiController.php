<?php
declare(strict_types=1);

namespace Alignant\Temperature\controller;

use Alignant\Temperature\DTO\FailedResponse;
use Alignant\Temperature\DTO\OkResponse;
use Alignant\Temperature\models\TemperatureAverage;
use Alignant\Temperature\models\TemperatureReading;
use Alignant\Temperature\models\TemperatureSensorAverage;
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

    public function average(): Response
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->headers->set('Content-Type', 'application/json');

        $days = $request->query->get('days');
        $model = new TemperatureAverage();
        $model->setDays($days);
        $data = $model->read();
        if (is_null($data)) {
            return $response->setContent((new FailedResponse('average'))->toJSON());
        }

        $response->setContent($data->toJSON());
        return $response;
    }

    public function sensor_average(): Response
    {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $response->headers->set('Content-Type', 'application/json');
        $sensorUuid = $request->query->get('sensor_uuid');
        $model = new TemperatureSensorAverage();
        $model->setSensorUUID((string)$sensorUuid);
        $data = $model->read();
        if (is_null($data)) {
            return $response->setContent((new FailedResponse('sensor_average'))->toJSON());
        }

        $response->setContent($data->toJSON());
        return $response;
    }
}
