<?php
declare(strict_types=1);
namespace Alignant\Temperature\DTO;

class OkResponse extends BasicDTO
{
    public readonly string $status;
    public function __construct(
        readonly public string $action
    ) {
        $this->status = 'OK';
    }
}