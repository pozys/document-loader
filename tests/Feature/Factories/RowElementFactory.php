<?php

declare(strict_types=1);

namespace Tests\Feature\Factories;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Enums\TriggerPositions;
use App\Domain\Concerns\Models\SchemaComponents\Row;
use App\Domain\Concerns\Models\ValueObjects\Trigger;

final class RowElementFactory
{
    private array $properties = [];
    private Trigger $trigger;

    public static function createSameRow(string $triggerText, string ...$primitiveElementTexts): Row
    {
        $rowBuilder = self::baseRowElement();
        $rowBuilder->setSamePosition($triggerText);

        $row = collect($primitiveElementTexts)
            ->reduce(static fn (self $rowBuilder, string $text) => $rowBuilder->addProperty($text), $rowBuilder)
            ->build();

        return $row;
    }

    public static function createBeforeRow(string $triggerText, string ...$primitiveElementTexts): Row
    {
        $rowBuilder = self::baseRowElement();
        $rowBuilder->setBeforePosition($triggerText);

        $row = collect($primitiveElementTexts)
            ->reduce(static fn (self $rowBuilder, string $text) => $rowBuilder->addProperty($text), $rowBuilder)
            ->build();

        return $row;
    }

    private static function baseRowElement(): self
    {
        return new self();
    }

    private function setSamePosition(string $text): self
    {
        $this->trigger = $this->getNewTrigger($text, TriggerPositions::Same->value);

        return $this;
    }

    private function setBeforePosition(string $text): self
    {
        $this->trigger = $this->getNewTrigger($text, TriggerPositions::Before->value);

        return $this;
    }

    private function getNewTrigger(string $text, string $position): Trigger
    {
        return new Trigger($text, $position);
    }

    private function addProperty(string $name, ?string $type = SchemaComponentTypes::Integer->value): self
    {
        $this->properties[] = compact('name', 'type');

        return $this;
    }

    private function build(): Row
    {
        return new Row(SchemaComponentTypes::Row, [
            'properties' => $this->properties,
            'trigger' => $this->trigger
        ]);
    }
}
