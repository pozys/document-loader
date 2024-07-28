<?php

declare(strict_types=1);

namespace App\Domain\DTO;

class ParsedDocumentDto
{
    public function __construct(public readonly array $content)
    {
    }
}
