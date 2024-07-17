<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;

class CheckDocumentRequest
{
    public function __construct(
        public readonly DocumentTypes $type,
        public readonly DocumentFormats $format,
        public readonly string $path,
    ) {
    }
}
