<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\DTO\ParsedDocumentDto;
use App\Domain\Interfaces\Structuring;
use App\Domain\Models\Setting\Setting;

interface DocumentProcessorInterface
{
    public function readBySettings(
        string $path,
        Setting $setting,
        Structuring ...$schemaElements
    ): ParsedDocumentDto;
}
