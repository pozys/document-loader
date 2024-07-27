<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Domain\Concerns\Models\SchemaComponents\AbstractSchemaComponent;
use App\Domain\Models\Setting\Setting;

interface DocumentProcessorInterface
{
    public function readBySettings(string $path, Setting $setting, AbstractSchemaComponent ...$schemaElements): array;
}
