<?php
declare(strict_types=1);

namespace Alignant\Temperature\models;

use Alignant\Temperature\DTO\TemperatureReadingData;
use DateTimeImmutable;
use Doctrine\DBAL\Exception;

class TemperatureReading
{
    private array $data;
    public function setData(array $data)
    {
        $this->data = $data;
    }


    public function save(): bool
    {
        $object = $this->getValidatedData();
        if (is_null($object)) {
            return false;
        }


        try {
            global $Application;
            $conn = $Application->getConnection();
            $conn->insert('temperature_reading', [
                    'sensor_uuid' => $object->sensor_uuid,
                    'temperature' => $object->temperature,
                    'reading_time' => $object->reading_time->format('Y-m-d H:i:s'),
                ]
            );

        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    private function getValidatedData(): ?TemperatureReadingData
    {
        $temp = $this->data['reading']['temperature'] ?? null;
        if (!is_float($temp)) {
            return null;
        }

        $uuid = $this->data['reading']['sensor_uuid'] ?? null;
        if (!is_string($uuid)) {
            return null;
        }

        $now = new DateTimeImmutable('now');
        return new TemperatureReadingData((string)$uuid, $temp, $now);
    }

    private function getSQL(TemperatureReadingData $data): string
    {


    }
}