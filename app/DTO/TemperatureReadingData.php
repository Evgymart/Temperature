<?php

namespace Alignant\Temperature\DTO;

use DateTimeImmutable;

class TemperatureReadingData extends BasicDTO
{
    public function __construct(
        readonly public string $sensor_uuid,
        readonly public float $temperature,
        readonly public DateTimeImmutable $reading_time,
    ) {
    }

}