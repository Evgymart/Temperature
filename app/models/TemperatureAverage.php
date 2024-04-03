<?php

namespace Alignant\Temperature\models;

use Alignant\Temperature\DTO\AverageTemperatureData;
use DateTimeImmutable;

class TemperatureAverage
{
    private ?int $days;

    public function read(): ?AverageTemperatureData
    {
        global $Application;
        $conn = $Application->getConnection();
        try {
            $stmt = null;
            $latestDate = $this->getLatestDate();
            if (is_null($latestDate)) {
                $sql = 'SELECT AVG(temperature) FROM temperature_reading;';
                $stmt = $conn->prepare($sql);
            } else {
                $sql = 'SELECT AVG(temperature) FROM temperature_reading WHERE reading_time > ?;';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $latestDate->format('Y-m-d H:i:s'));
            }
            $result = $stmt->executeQuery();
            $averageTemperature = $result->fetchOne();
            return new AverageTemperatureData($averageTemperature, $this->days);
        } catch (\Throwable) {
            return null;
        }
    }

    public function setDays(mixed $days): void
    {
        $this->days = !is_null($days) ? (int)$days : null;
    }

    /**
     * @throws \Exception
     */
    private function getLatestDate(): ?DateTimeImmutable
    {
        if (!is_integer($this->days)) {
            return null;
        }

        $strtime = strtotime('-' . $this->days . ' days');
        return new DateTimeImmutable(date('Y-m-d H:i:s', $strtime));
    }
}