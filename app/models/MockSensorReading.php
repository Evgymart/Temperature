<?php

namespace Alignant\Temperature\models;

use Alignant\Temperature\DTO\MockSensorReadingData;

class MockSensorReading
{
    private ?string $ip;
    public function setIP(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $this->ip = null;
        } else {
            $this->ip = $ip;
        }
    }

    public function read(): ?MockSensorReadingData
    {
        if (is_null($this->ip)) {
            return null;
        }

        $sensorData = null;

        global $Application;
        $conn = $Application->getConnection();
        try {
            $conn->beginTransaction();
            $stmt = $conn->prepare("SELECT id, reading_count FROM mock_sensor WHERE ip = ? LIMIT 1");
            $stmt->bindValue(1, $this->ip);
            $result = $stmt->executeQuery();
            $data = $result->fetchAllAssociative()[0] ?? null;
            $readingCount = $data['reading_count'] ?? null;
            if (is_null($readingCount)) {
                $conn->insert('mock_sensor', [
                    'ip' => $this->ip
                ]);
                $sensorData = new MockSensorReadingData(0, $this->generateTemperature());
            } else {
                $conn->update('mock_sensor', ['reading_count' => $readingCount + 1], ['id' => $data['id']]);
                $sensorData = new MockSensorReadingData($readingCount, $this->generateTemperature());
            }

            $conn->commit();

        } catch (\Throwable $e) {
            return null;
        }

        return $sensorData;
    }

    private function generateTemperature(): float
    {
        return rand(-9, 79) + (rand(0, 100) * 0.01);
    }
}