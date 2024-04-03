<?php
declare(strict_types=1);
namespace Alignant\Temperature\DTO;

class MockSensorReadingData extends CsvDTO
{
    public function __construct(
        readonly public int $readingId,
        readonly public float $temperature,
    ) {
    }
}
