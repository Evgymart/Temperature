<?php

namespace Alignant\Temperature\DTO;

abstract class CsvDTO
{
    public function toCSV(): string
    {
        return implode(", ", (array)$this);
    }
}
