<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Models\Setting\Setting;

class CheckDocumentRequest
{
    public function __construct(
        public readonly string $path,
        public readonly Setting $setting,
        public readonly DocumentSchema $documentSchema,
    ) {
    }
}
