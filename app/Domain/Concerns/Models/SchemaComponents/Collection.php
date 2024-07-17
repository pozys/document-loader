<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Factories\SchemaComponentFactory;

class Collection extends AbstractSchemaComponent
{
    private AbstractSchemaComponent $item;

    public function applyData(?array $data): static
    {
        $this->validate($data);
        $this->item = SchemaComponentFactory::make("{$this->name}.item", $data['items']);

        return $this;
    }

    private function validate(?array $data): void
    {
        if ($data === null) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No data provided for collection schema component');
        }

        if (!isset($data['items'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No item provided for collection schema component');
        }
    }
}
