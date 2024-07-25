<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Concerns\Models\ValueObjects\Trigger;
use App\Domain\Factories\SchemaComponentFactory;

class Row extends AbstractSchemaComponent
{
    private array $properties = [];
    private Trigger $trigger;

    public function applyData(array $data): static
    {
        $this->validate($data);
        $this->setTrigger($data);
        $this->setProperties($data);

        return $this;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getTrigger(): Trigger
    {
        return $this->trigger;
    }

    private function validate(array $data): void
    {
        if (!isset($data['properties'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No properties provided for row schema component');
        }

        if (!isset($data['trigger'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No trigger provided for row schema component');
        }
    }

    private function setTrigger(array $data): void
    {
        $trigger = data_get($data, 'trigger');

        $this->trigger = new Trigger(data_get($trigger, 'text', ''), data_get($trigger, 'position', ''));
    }

    private function setProperties(array $data): void
    {
        foreach ($data['properties'] ?? [] as $data) {
            $this->properties[] = SchemaComponentFactory::make($data);
        }
    }
}
