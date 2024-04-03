<?php

namespace Alignant\Temperature\DTO;

class FailedResponse extends JsonDTO
{
    public readonly string $status;
    public function __construct(
        readonly public string $action
    ) {
        $this->status = 'Failure';
    }
}