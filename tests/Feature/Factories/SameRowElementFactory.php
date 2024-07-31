<?php

declare(strict_types=1);

namespace Tests\Feature\Factories;

use App\Domain\Concerns\Enums\SchemaComponentTypes;
use App\Domain\Concerns\Models\SchemaComponents\Row;

class SameRowElementFactory
{
    public static function create(string $triggerText, string $primitiveElementText): Row
    {
        $row = new Row(SchemaComponentTypes::Row, [
            'properties' => [
                [
                    'type' => SchemaComponentTypes::Integer->value,
                    'name' => $primitiveElementText
                ]
            ],
            'trigger' => ['text' => $triggerText, 'position' => 'same']
        ]);

        return $row;
    }
}
