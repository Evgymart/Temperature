<?php

namespace Alignant\Temperature\DTO;

abstract class JsonDTO
{
    public function toJSON(): string
    {
        return json_encode($this);
    }
}
