<?php

declare(strict_types=1);

namespace Tests\Feature\Factories;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Enums\TriggerPositions;
use App\Domain\Concerns\Models\SchemaComponents\Collection;
use App\Domain\Concerns\Models\ValueObjects\Trigger;

final class CollectionElementFactory
{
    public static function create(
        string $name,
        string $triggerText,
        string ...$primitiveElementTexts
    ): Collection {
        $trigger = new Trigger($triggerText, TriggerPositions::Before->value);

        $properties = collect($primitiveElementTexts)
            ->map(static fn (string $text) => [
                'name' => $text,
                'type' => SchemaComponentTypes::Integer->value,
                'is_control' => true
            ]);

        return new Collection(SchemaComponentTypes::Collection, [
            'name' => $name,
            'trigger' => $trigger,
            'properties' => $properties
        ]);
    }
}
