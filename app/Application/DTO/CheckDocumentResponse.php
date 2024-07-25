<?php

declare(strict_types=1);

namespace App\Application\DTO;

class CheckDocumentResponse
{
    public function __construct(public readonly array $parsedDocument, public readonly ValidationError ...$errors)
    {
    }
}
