<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Factories\SchemaComponentFactory;

class Structure extends AbstractSchemaComponent
{
    private array $properties = [];

    public function applyData(?array $data): static
    {
        $this->validate($data);

        foreach ($data['properties'] as $name => $data) {
            $this->properties[] = SchemaComponentFactory::make("$this->name.$name", $data);
        }

        return $this;
    }

    private function validate(?array $data): void
    {
        if ($data === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No data provided for structure schema component');
        }

        if (!isset($data['properties'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No properties provided for structure schema component');
        }
    }
}
