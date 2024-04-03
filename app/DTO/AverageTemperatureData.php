<?php
declare(strict_types=1);
namespace Alignant\Temperature\DTO;

class AverageTemperatureData extends JsonDTO
{
    public function __construct(
        readonly public float $average_temperature,
        readonly public ?int $for_days,
    ) {
    }
}
