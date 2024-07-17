<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Concerns\Enums\SchemaComponentTypes;

abstract class AbstractSchemaComponent
{
    public function __construct(protected SchemaComponentTypes $type, protected string $name, ?array $data = null)
    {
        $this->applyData($data);
    }

    abstract protected function applyData(?array $data): static;
}
