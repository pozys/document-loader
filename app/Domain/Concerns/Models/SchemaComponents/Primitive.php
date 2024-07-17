<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

class Primitive extends AbstractSchemaComponent
{
    public function applyData(?array $data): static
    {
        $this->validate($data);

        return $this;
    }

    private function validate(?array $data): void
    {
        if ($data !== null) {
            // TODO: throw exception
            throw new \InvalidArgumentException('Cannot apply data to primitive schema component');
        }
    }
}
