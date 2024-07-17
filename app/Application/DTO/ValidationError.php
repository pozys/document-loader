<?php

declare(strict_types=1);

namespace App\Application\DTO;

class ValidationError
{
    public function __construct(public readonly string $field, public readonly string $message)
    {
    }
}
