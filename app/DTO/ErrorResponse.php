<?php
declare(strict_types=1);

namespace Alignant\Temperature\DTO;

class ErrorResponse extends BasicDTO
{
    public function __construct(
        readonly public string $error,
        readonly public int $code
    ) {
    }
}
