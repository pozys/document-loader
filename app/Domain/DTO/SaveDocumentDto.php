<?php

declare(strict_types=1);

namespace App\Domain\DTO;

use App\Domain\Concerns\Models\DocumentSchema;
use App\Domain\Models\Setting\Setting;

class SaveDocumentDto
{
    public function __construct(
        public readonly Setting $setting,
        public readonly DocumentSchema $schema,
        public readonly array $content,
        public readonly array $errors,
    ) {
    }
}
