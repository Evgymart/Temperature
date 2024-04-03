<?php
declare(strict_types=1);
namespace Alignant\Temperature\DTO;

class TemperatureSensorAverageData extends JsonDTO
{
    public function __construct(
        readonly public float $average_temperature,
        readonly public string $sensor_uuid,
    ) {
    }
}
