<?php

namespace Alignant\Temperature\models;

use Alignant\Temperature\DTO\TemperatureSensorAverageData;
use DateTimeImmutable;

class TemperatureSensorAverage
{
    private ?string $sensorUUID;

    public function setSensorUUID(string $uuid)
    {
        $this->sensorUUID = $uuid;
    }

    public function read(): ?TemperatureSensorAverageData
    {
        if (is_null($this->sensorUUID)) {
            return null;
        }

        global $Application;
        $conn = $Application->getConnection();
        try {
            $sql = 'SELECT AVG(temperature) FROM temperature_reading WHERE reading_time > ? AND sensor_uuid = ? GROUP BY sensor_uuid LIMIT 1;';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $this->getLatestTime()->format('Y-m-d H:i:s'));
            $stmt->bindValue(2, $this->sensorUUID);

            $result = $stmt->executeQuery();
            $averageTemperature = $result->fetchOne();
            return new TemperatureSensorAverageData($averageTemperature, $this->sensorUUID);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * @throws \Exception
     */
    private function getLatestTime(): DateTimeImmutable
    {
        $strtime = strtotime('-1 hour');
        return new DateTimeImmutable(date('Y-m-d H:i:s', $strtime));
    }
}
