<?php

declare(strict_types=1);

namespace App\Application\DTO;

class CheckDocumentResponse
{
    public function __construct(public readonly int $id, public readonly array $summary, public readonly array $errors)
    {
    }
}
