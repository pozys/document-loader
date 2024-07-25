<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Concerns\Enums\SchemaComponentTypes;

abstract class AbstractSchemaComponent
{
    public function __construct(protected SchemaComponentTypes $type, array $data)
    {
        $this->applyData($data);
    }

    public function getType(): SchemaComponentTypes
    {
        return $this->type;
    }

    abstract protected function applyData(array $data): static;
}
