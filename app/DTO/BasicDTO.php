<?php

namespace Alignant\Temperature\DTO;

abstract class BasicDTO
{
    public function toJSON(): string
    {
        return json_encode($this);
    }
}