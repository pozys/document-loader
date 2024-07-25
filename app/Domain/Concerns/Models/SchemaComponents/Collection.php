<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

use App\Domain\Concerns\Models\ValueObjects\Trigger;
use App\Domain\Factories\SchemaComponentFactory;

class Collection extends AbstractSchemaComponent
{
    private string $name;
    private array $properties;
    private Trigger $trigger;

    public function applyData(array $data): static
    {
        $this->validate($data);
        $this->setName($data);
        $this->setTrigger($data);
        $this->setProperties($data);

        return $this;
    }

    public function getTrigger(): Trigger
    {
        return $this->trigger;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function setName(array $data): void
    {
        $this->name = $data['name'];
    }

    private function setTrigger(array $data): void
    {
        $trigger = data_get($data, 'trigger');

        $this->trigger = new Trigger(data_get($trigger, 'text', ''), data_get($trigger, 'position', ''));
    }

    private function validate(array $data): void
    {
        if (!isset($data['properties'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No properties provided for collection schema component');
        }

        if (!isset($data['trigger'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No trigger provided for collection schema component');
        }

        if (!isset($data['name'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No name provided for collection schema component');
        }
    }

    private function setProperties(array $data): void
    {
        foreach ($data['properties'] ?? [] as $data) {
            $this->properties[] = SchemaComponentFactory::make($data);
        }
    }
}
