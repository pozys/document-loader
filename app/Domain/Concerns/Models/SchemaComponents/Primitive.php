<?php

declare(strict_types=1);

namespace App\Domain\Concerns\Models\SchemaComponents;

class Primitive extends AbstractSchemaComponent
{
    private string $name;
    private bool $isControl = false;

    public function applyData(array $data): static
    {
        $this->validate($data);
        $this->setName($data);
        $this->setIsControl($data);

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isControl(): bool
    {
        return $this->isControl;
    }

    private function setName(array $data): void
    {
        $this->name = $data['name'];
    }

    private function setIsControl(array $data): void
    {
        $this->isControl = (bool) data_get($data, 'is_control', false);
    }

    private function validate(array $data): void
    {
        if (!isset($data['name'])) {
            // TODO: throw exception
            throw new \InvalidArgumentException('No name provided for primitive schema component');
        }
    }
}
